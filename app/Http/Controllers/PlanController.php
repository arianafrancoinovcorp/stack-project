<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::where('is_active', true)
                    ->orderBy('sort_order')
                    ->get();

        $currentTenant = tenant();
        $currentSubscription = $currentTenant?->subscription;

        $currentPlan = ($currentSubscription && !$currentSubscription->isCanceled()) 
            ? $currentSubscription->plan 
            : null;

        return view('plans.index', compact('plans', 'currentPlan', 'currentSubscription'));
    }

    public function show(Plan $plan)
    {
        $currentTenant = tenant();
        $currentSubscription = $currentTenant?->subscription;

        $currentPlan = ($currentSubscription && !$currentSubscription->isCanceled()) 
            ? $currentSubscription->plan 
            : null;

        return view('plans.show', compact('plan', 'currentPlan'));
    }
}
