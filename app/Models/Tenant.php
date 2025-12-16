<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    /**
     * Users belonging to the tenant
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Tenant owner
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Tenant plan
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Active or trialing subscription
     */
    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class)
            ->whereIn('status', ['active', 'trialing'])
            ->latest();
    }

    /**
     * All subscriptions
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Entities owned by tenant
     */
    public function entities(): HasMany
    {
        return $this->hasMany(Entity::class);
    }

    /**
     * Proposals owned by tenant
     */
    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    /**
     * Orders owned by tenant
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if onboarding step is completed
     */
    public function hasCompletedStep(string $step): bool
    {
        $steps = $this->onboarding_steps ?? [];

        return in_array($step, $steps, true);
    }

    /**
     * Mark onboarding step as complete
     */
    public function completeStep(string $step): void
    {
        $steps = $this->onboarding_steps ?? [];

        if (!in_array($step, $steps, true)) {
            $steps[] = $step;
            $this->onboarding_steps = $steps;
        }

        $allSteps = ['welcome', 'branding', 'team', 'preferences'];

        if (count(array_intersect($steps, $allSteps)) === count($allSteps)) {
            $this->onboarding_completed = true;
        }

        $this->save();
    }

    /**
     * Get next onboarding step
     */
    public function getNextOnboardingStep(): string
    {
        $allSteps = ['welcome', 'branding', 'team', 'preferences'];
        $completed = $this->onboarding_steps ?? [];

        foreach ($allSteps as $step) {
            if (!in_array($step, $completed, true)) {
                return $step;
            }
        }

        return 'complete';
    }

    /**
     * Check if tenant can use a feature
     */
    public function canUse(string $feature, int $count = 1): bool
    {
        if (!$this->plan) {
            return false;
        }

        $limit = $this->plan->{"max_{$feature}"};

        if (is_null($limit)) {
            return true;
        }

        if (!method_exists($this, $feature)) {
            return false;
        }

        $current = $this->{$feature}()->count();

        return ($current + $count) <= $limit;
    }

    /**
     * Check if tenant has reached feature limit
     */
    public function hasReachedLimit(string $feature): bool
    {
        if (!$this->plan) {
            return true;
        }

        $limit = $this->plan->{"max_{$feature}"};

        if (is_null($limit)) {
            return false;
        }

        if (!method_exists($this, $feature)) {
            return true;
        }

        $current = $this->{$feature}()->count();

        return $current >= $limit;
    }
}
