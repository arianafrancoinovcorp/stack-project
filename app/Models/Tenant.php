<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'name', 
        'slug', 
        'settings', 
        'owner_id',
        'logo',
        'primary_color',
        'secondary_color',
        'status',
        'trial_ends_at',
        'onboarding_completed',
        'onboarding_steps'
    ];

    protected $casts = [
        'settings' => 'array',
        'onboarding_steps' => 'array',
        'onboarding_completed' => 'boolean',
        'trial_ends_at' => 'datetime',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * check if onboarding is complete
     */
    public function hasCompletedStep($step)
    {
        $steps = $this->onboarding_steps ?? [];
        return in_array($step, $steps);
    }

    /**
     * mark step as complete
     */
    public function completeStep($step)
    {
        $steps = $this->onboarding_steps ?? [];
        
        if (!in_array($step, $steps)) {
            $steps[] = $step;
            $this->onboarding_steps = $steps;
            $this->save();
        }

        $allSteps = ['welcome', 'branding', 'team', 'preferences'];
        if (count(array_intersect($steps, $allSteps)) === count($allSteps)) {
            $this->onboarding_completed = true;
            $this->save();
        }
    }

    public function getNextOnboardingStep()
    {
        $allSteps = ['welcome', 'branding', 'team', 'preferences'];
        $completed = $this->onboarding_steps ?? [];

        foreach ($allSteps as $step) {
            if (!in_array($step, $completed)) {
                return $step;
            }
        }

        return 'complete';
    }
}