<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OnboardingController extends Controller
{
    /**
     * show wizard of onboarding
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $tenant = tenant();

        if (!$tenant) {
            return redirect()->route('tenants.create');
        }

        if ($tenant->onboarding_completed) {
            return redirect()->route('dashboard')->with('info', 'Onboarding already completed!');
        }

        $currentStep = $tenant->getNextOnboardingStep();

        return view('onboarding.' . $currentStep, compact('tenant', 'currentStep'));
    }

    /**
     * Welcome step
     */
    public function welcome()
    {
        $tenant = tenant();
        $tenant->completeStep('welcome');

        return redirect()->route('onboarding.index');
    }

    /**
     * Branding step
     */
    public function branding(Request $request)
    {
        $tenant = tenant();

        $data = $request->validate([
            'logo' => 'nullable|image|max:2048',
            'primary_color' => 'required|string|max:7',
            'secondary_color' => 'required|string|max:7',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($tenant->logo) {
                Storage::disk('public')->delete($tenant->logo);
            }

            $path = $request->file('logo')->store('logos', 'public');
            $tenant->logo = $path;
        }

        $tenant->primary_color = $data['primary_color'];
        $tenant->secondary_color = $data['secondary_color'];
        $tenant->save();

        $tenant->completeStep('branding');

        return redirect()->route('onboarding.index')->with('success', 'Branding saved!');
    }

    /**
     * Team step
     */
    public function team(Request $request)
    {
        $tenant = tenant();

        $data = $request->validate([
            'emails' => 'nullable|string',
        ]);

        if (!empty($data['emails'])) {
            $emails = array_filter(array_map('trim', explode(',', $data['emails'])));

            foreach ($emails as $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    
                    $user = User::where('email', $email)->first();

                    if ($user && !$tenant->users()->where('user_id', $user->id)->exists()) {
                        
                        $tenant->users()->attach($user->id, ['role' => 'user']);
                    }
                }
            }
        }

        $tenant->completeStep('team');

        return redirect()->route('onboarding.index')->with('success', 'Team members added!');
    }

    /**
     * Preferences step
     */
    public function preferences(Request $request)
    {
        $tenant = tenant();

        $data = $request->validate([
            'timezone' => 'nullable|string',
            'language' => 'nullable|string',
            'currency' => 'nullable|string',
        ]);

        $settings = $tenant->settings ?? [];
        $settings['timezone'] = $data['timezone'] ?? 'UTC';
        $settings['language'] = $data['language'] ?? 'en';
        $settings['currency'] = $data['currency'] ?? 'EUR';

        $tenant->settings = $settings;
        $tenant->save();

        $tenant->completeStep('preferences');

        return redirect()->route('dashboard')->with('success', 'Onboarding completed!');
    }

    /**
     * skip onboarding
     */
    public function skip()
    {
        $tenant = tenant();
        $tenant->onboarding_completed = true;
        $tenant->save();

        return redirect()->route('dashboard')->with('info', 'Onboarding skipped. You can configure your tenant later in settings.');
    }
}