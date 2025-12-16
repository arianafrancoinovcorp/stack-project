<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionChange;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function dashboard()
    {
        $tenant = tenant();
        $subscription = $tenant->subscription;

        $plan = ($subscription && !$subscription->isCanceled()) ? $subscription->plan : null;

        $usage = [
            'users' => $tenant->users()->count(),
            'entities' => $tenant->entities()->count(),
            'proposals' => $tenant->proposals()->whereMonth('created_at', now()->month)->count(),
            'orders' => $tenant->orders()->whereMonth('created_at', now()->month)->count(),
        ];

        $limits = [
            'users' => $plan?->max_users,
            'entities' => $plan?->max_entities,
            'proposals' => $plan?->max_proposals,
            'orders' => $plan?->max_orders,
        ];

        $percentages = [
            'users' => $limits['users'] ? min(($usage['users'] / $limits['users']) * 100, 100) : 10,
            'entities' => $limits['entities'] ? min(($usage['entities'] / $limits['entities']) * 100, 100) : 10,
            'proposals' => $limits['proposals'] ? min(($usage['proposals'] / $limits['proposals']) * 100, 100) : 10,
            'orders' => $limits['orders'] ? min(($usage['orders'] / $limits['orders']) * 100, 100) : 10,
        ];

        $changes = $subscription 
            ? $subscription->changes()->with(['user', 'fromPlan', 'toPlan'])->latest()->take(10)->get() 
            : collect();

        return view('subscriptions.dashboard', compact(
            'tenant',
            'subscription',
            'plan',
            'usage',
            'limits',
            'percentages',
            'changes'
        ));
    }

    public function subscribe(Request $request, Plan $plan)
    {
        /** @var User $user */
        $user = Auth::user();
        $tenant = tenant();

        if ($tenant->subscription && $tenant->subscription->isActive()) {
            return redirect()->back()->with('error', 'You already have an active subscription.');
        }

        $data = $request->validate([
            'billing_cycle' => 'required|in:monthly,yearly'
        ]);

        $amount = $data['billing_cycle'] === 'monthly' ? $plan->price_monthly : $plan->price_yearly;

        $subscription = Subscription::create([
            'tenant_id' => $tenant->id,
            'plan_id' => $plan->id,
            'billing_cycle' => $data['billing_cycle'],
            'amount' => $amount,
            'starts_at' => now(),
            'trial_ends_at' => $plan->trial_days > 0 ? now()->addDays($plan->trial_days) : null,
            'status' => $plan->trial_days > 0 ? 'trialing' : 'active',
            'next_payment_at' => $plan->trial_days > 0 
                ? now()->addDays($plan->trial_days)
                : ($data['billing_cycle'] === 'monthly' ? now()->addMonth() : now()->addYear()),
        ]);

        $tenant->plan_id = $plan->id;
        $tenant->status = $plan->trial_days > 0 ? 'trial' : 'active';
        $tenant->trial_ends_at = $subscription->trial_ends_at;
        $tenant->save();

        SubscriptionChange::create([
            'subscription_id' => $subscription->id,
            'user_id' => $user->id,
            'action' => 'created',
            'to_plan_id' => $plan->id,
            'amount' => $amount,
            'notes' => "Subscribed to {$plan->name} plan ({$data['billing_cycle']})"
        ]);

        return redirect()->route('subscriptions.dashboard')
            ->with('success', "Successfully subscribed to {$plan->name} plan!");
    }

    public function upgrade(Request $request, Plan $plan)
    {
        /** @var User $user */
        $user = Auth::user();
        $tenant = tenant();
        $currentSubscription = $tenant->subscription;

        if (!$currentSubscription) {
            return redirect()->route('plans.index')->with('error', 'No active subscription found.');
        }

        $currentPlan = $currentSubscription->plan;

        if ($plan->price_monthly <= $currentPlan->price_monthly) {
            return redirect()->back()->with('error', 'Please select a higher plan to upgrade.');
        }

        $data = $request->validate([
            'billing_cycle' => 'required|in:monthly,yearly'
        ]);

        $daysRemaining = now()->diffInDays($currentSubscription->next_payment_at ?? now());
        $totalDaysInCycle = $currentSubscription->billing_cycle === 'monthly' ? 30 : 365;
        $creditRatio = $daysRemaining / $totalDaysInCycle;
        $credit = $currentSubscription->amount * $creditRatio;

        $newAmount = $data['billing_cycle'] === 'monthly' ? $plan->price_monthly : $plan->price_yearly;
        $amountToPay = max(0, $newAmount - $credit);

        $currentSubscription->update([
            'plan_id' => $plan->id,
            'billing_cycle' => $data['billing_cycle'],
            'amount' => $newAmount,
            'status' => 'active',
            'next_payment_at' => $data['billing_cycle'] === 'monthly' 
                ? now()->addMonth() 
                : now()->addYear(),
        ]);

        $tenant->plan_id = $plan->id;
        $tenant->status = 'active';
        $tenant->save();

        SubscriptionChange::create([
            'subscription_id' => $currentSubscription->id,
            'user_id' => $user->id,
            'action' => 'upgraded',
            'from_plan_id' => $currentPlan->id,
            'to_plan_id' => $plan->id,
            'amount' => $amountToPay,
            'notes' => "Upgraded from {$currentPlan->name} to {$plan->name} (pro-rata credit: €" . number_format($credit, 2) . ")"
        ]);

        return redirect()->route('subscriptions.dashboard')
            ->with('success', "Successfully upgraded to {$plan->name} plan! You were credited €" . number_format($credit, 2) . " for the remaining time.");
    }

    public function downgrade(Request $request, Plan $plan)
    {
        /** @var User $user */
        $user = Auth::user();
        $tenant = tenant();
        $currentSubscription = $tenant->subscription;

        if (!$currentSubscription) {
            return redirect()->route('plans.index')->with('error', 'No active subscription found.');
        }

        $currentPlan = $currentSubscription->plan;

        if ($plan->price_monthly >= $currentPlan->price_monthly) {
            return redirect()->back()->with('error', 'Please select a lower plan to downgrade.');
        }

        $currentSubscription->update([
            'auto_renew' => true,
            'notes' => "Scheduled downgrade to {$plan->name} on next billing cycle"
        ]);

        SubscriptionChange::create([
            'subscription_id' => $currentSubscription->id,
            'user_id' => $user->id,
            'action' => 'downgraded',
            'from_plan_id' => $currentPlan->id,
            'to_plan_id' => $plan->id,
            'amount' => 0,
            'notes' => "Scheduled downgrade from {$currentPlan->name} to {$plan->name} (effective on next billing cycle)"
        ]);

        return redirect()->route('subscriptions.dashboard')
            ->with('success', "Downgrade to {$plan->name} scheduled for next billing cycle on " . ($currentSubscription->next_payment_at?->format('M d, Y') ?? 'N/A'));
    }

    public function cancel(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $tenant = tenant();
        $subscription = $tenant->subscription;

        if (!$subscription) {
            return redirect()->back()->with('error', 'No active subscription found.');
        }

        $immediately = $request->boolean('immediately', false);

        $subscription->cancel($immediately);

        SubscriptionChange::create([
            'subscription_id' => $subscription->id,
            'user_id' => $user->id,
            'action' => 'canceled',
            'from_plan_id' => $subscription->plan_id,
            'amount' => 0,
            'notes' => $immediately 
                ? 'Subscription canceled immediately' 
                : 'Subscription will be canceled at end of billing period'
        ]);

        if ($immediately) {
            $tenant->plan_id = null;
            $tenant->status = 'canceled';
            $tenant->save();
        }

        $message = $immediately 
            ? 'Subscription canceled immediately.' 
            : 'Subscription will be canceled on ' . ($subscription->next_payment_at?->format('M d, Y') ?? 'N/A');

        return redirect()->route('subscriptions.dashboard')
            ->with('success', $message);
    }

    public function resume()
    {
        /** @var User $user */
        $user = Auth::user();
        $tenant = tenant();
        $subscription = $tenant->subscription;

        if (!$subscription || !$subscription->isCanceled()) {
            return redirect()->back()->with('error', 'No canceled subscription found.');
        }

        $subscription->renew();

        SubscriptionChange::create([
            'subscription_id' => $subscription->id,
            'user_id' => $user->id,
            'action' => 'renewed',
            'to_plan_id' => $subscription->plan_id,
            'amount' => $subscription->amount,
            'notes' => 'Subscription renewed'
        ]);

        $tenant->plan_id = $subscription->plan_id;
        $tenant->status = 'active';
        $tenant->save();

        return redirect()->route('subscriptions.dashboard')
            ->with('success', 'Subscription successfully resumed!');
    }
}
