<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Subscription extends Model
{
    protected $fillable = [
        'tenant_id',
        'plan_id',
        'billing_cycle',
        'amount',
        'starts_at',
        'ends_at',
        'trial_ends_at',
        'canceled_at',
        'status',
        'auto_renew',
        'payment_method',
        'last_payment_at',
        'next_payment_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'canceled_at' => 'datetime',
        'last_payment_at' => 'datetime',
        'next_payment_at' => 'datetime',
        'auto_renew' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }


    public function changes()
    {
        return $this->hasMany(SubscriptionChange::class);
    }


    public function isOnTrial()
    {
        return $this->status === 'trialing' && $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }


    public function isActive()
    {
        return in_array($this->status, ['trialing', 'active']);
    }


    public function isCanceled()
    {
        return $this->status === 'canceled' || !is_null($this->canceled_at);
    }


    public function trialDaysRemaining()
    {
        if (!$this->isOnTrial()) {
            return 0;
        }

        return $this->trial_ends_at->diffInDays(now());
    }

    public function cancel($immediately = false)
    {
        if ($immediately) {
            $this->status = 'canceled';
            $this->ends_at = now();
        } else {
            $this->auto_renew = false;
        }

        $this->canceled_at = now();
        $this->save();
    }

    public function renew()
    {
        $this->status = 'active';
        $this->canceled_at = null;
        $this->auto_renew = true;
        
        if ($this->billing_cycle === 'monthly') {
            $this->next_payment_at = now()->addMonth();
        } else {
            $this->next_payment_at = now()->addYear();
        }

        $this->save();
    }
}
