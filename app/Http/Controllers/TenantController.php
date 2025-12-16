<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TenantController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $tenants = $user->tenants()->with('owner')->get();
        return view('tenants.index', compact('tenants'));
    }

    public function create()
    {
        return view('tenants.create');
    }

    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(6);
        $data['owner_id'] = $user->id;
        $data['status'] = 'trial';
        $data['trial_ends_at'] = \Carbon\Carbon::now()->addDays(14);
        $data['onboarding_completed'] = false; 

        $tenant = Tenant::create($data);

        // Attach user as owner
        $tenant->users()->attach($user->id, ['role' => 'owner']);

        // Switch to new tenant
        session(['tenant_id' => $tenant->id]);

        return redirect()->route('onboarding.index') 
            ->with('success', 'Tenant created successfully!');
    }
    public function switch($id)
    {
        /** @var User $user */
        $user = Auth::user();

        // Verify user has access to this tenant
        if (!$user->tenants()->where('tenant_id', $id)->exists()) {
            abort(403, 'You do not have access to this tenant.');
        }

        session(['tenant_id' => $id]);

        return redirect()->back()->with('success', 'Switched tenant successfully!');
    }

    public function edit(Tenant $tenant)
    {
        /** @var User $user */
        $user = Auth::user();

        // Check if user is owner or admin
        $userRole = $tenant->users()->where('user_id', $user->id)->first()?->pivot->role;

        if (!in_array($userRole, ['owner', 'admin'])) {
            abort(403, 'Only owners and admins can edit tenant settings.');
        }

        return view('tenants.edit', compact('tenant'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        /** @var User $user */
        $user = Auth::user();

        // Check if user is owner or admin
        $userRole = $tenant->users()->where('user_id', $user->id)->first()?->pivot->role;

        if (!in_array($userRole, ['owner', 'admin'])) {
            abort(403, 'Only owners and admins can edit tenant settings.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tenant->update($data);

        return redirect()->route('tenants.index')
            ->with('success', 'Tenant updated successfully!');
    }
}
