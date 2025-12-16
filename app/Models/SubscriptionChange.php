<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionChange extends Model
{
    protected $fillable = [
        'subscription_id',
        'user_id',
        'action',
        'from_plan_id',
        'to_plan_id',
        'amount',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fromPlan()
    {
        return $this->belongsTo(Plan::class, 'from_plan_id');
    }

    public function toPlan()
    {
        return $this->belongsTo(Plan::class, 'to_plan_id');
    }
}