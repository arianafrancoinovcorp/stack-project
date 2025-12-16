<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckOnboarding
{
    public function handle(Request $request, Closure $next)
    {
        $tenant = tenant();

        if (!$tenant) {
            return $next($request);
        }

        if ($request->is('onboarding*') || $request->is('tenants*')) {
            return $next($request);
        }

        if (!$tenant->onboarding_completed) {
            return redirect()->route('onboarding.index');
        }

        return $next($request);
    }
}