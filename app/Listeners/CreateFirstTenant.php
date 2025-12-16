<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Models\Tenant;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CreateFirstTenant
{
    public function handle(Registered $event)
    {
        $user = $event->user;

        $tenant = Tenant::create([
            'name' => $user->name . "'s Workspace",
            'slug' => Str::slug($user->name . '-workspace-' . Str::random(6)),
            'owner_id' => $user->id,
            'status' => 'trial',
            'trial_ends_at' => Carbon::now()->addDays(14),
            'onboarding_completed' => false, 
        ]);

        // user as owner
        $tenant->users()->attach($user->id, ['role' => 'owner']);

        // ACTIVE TENANT
        session(['tenant_id' => $tenant->id]);
    }
}