<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Models\Tenant;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CreateFirstTenant
{
    public function handle(Registered $event)
    {
        $user = $event->user;

        $freePlan = Plan::where('slug', 'free')->first();

        $tenant = Tenant::create([
            'name' => $user->name . "'s Workspace",
            'slug' => Str::slug($user->name . '-workspace-' . Str::random(6)),
            'owner_id' => $user->id,
            'plan_id' => $freePlan?->id,
            'status' => 'active',
            'onboarding_completed' => false,
        ]);

        $tenant->users()->attach($user->id, ['role' => 'owner']);

        if ($freePlan) {
            Subscription::create([
                'tenant_id' => $tenant->id,
                'plan_id' => $freePlan->id,
                'billing_cycle' => 'monthly',
                'amount' => 0,
                'starts_at' => now(),
                'status' => 'active',
            ]);
        }
        session(['tenant_id' => $tenant->id]);
    }
}