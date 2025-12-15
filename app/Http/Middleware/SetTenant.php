<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SetTenant
{
    public function handle(Request $request, Closure $next)
    {
        /** @var User|null $user */
        $user = Auth::user();
        
        if (!$user) {
            return $next($request);
        }


        if (!session('tenant_id')) {
            $tenant = $user->tenants()->first();
            
            if ($tenant) {
                session(['tenant_id' => $tenant->id]);
            } else {
                if (!$request->is('tenants/create') && !$request->is('tenants')) {
                    return redirect()->route('tenants.create')
                        ->with('warning', 'You need to create or join a tenant first.');
                }
            }
        }

        $tenant = Tenant::find(session('tenant_id'));
        
        if ($tenant && !$user->tenants()->where('tenant_id', $tenant->id)->exists()) {
            session()->forget('tenant_id');
            $firstTenant = $user->tenants()->first();
            
            if ($firstTenant) {
                session(['tenant_id' => $firstTenant->id]);
                $tenant = $firstTenant;
            }
        }

        app()->instance('tenant', $tenant);

        if ($tenant) {
            view()->share('currentTenant', $tenant);
        }

        return $next($request);
    }
}