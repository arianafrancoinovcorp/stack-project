<?php
use Illuminate\Support\Facades\Auth;
use App\Models\User;

if (!function_exists('tenant')) {
    function tenant()
    {
        return app('tenant');
    }
}

if (!function_exists('currentTenantId')) {
    function currentTenantId()
    {
        return session('tenant_id');
    }
}

if (!function_exists('switchTenant')) {
    function switchTenant($tenantId)
    {
        /** @var User|null $user */
        $user = Auth::user();
        
        if ($user && $user->tenants()->where('tenant_id', $tenantId)->exists()) {
            session(['tenant_id' => $tenantId]);
            return true;
        }
        
        return false;
    }
}