<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_monthly',
        'price_yearly',
        'max_users',
        'max_entities',
        'max_proposals',
        'max_orders',
        'max_storage_mb',
        'features',
        'trial_days',
        'is_active',
        'is_featured',
        'sort_order'
    ];

    protected $casts = [
        'price_monthly' => 'decimal:2',
        'price_yearly' => 'decimal:2',
        'features' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Subscriptions
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }


    public function hasLimit($feature)
    {
        return !is_null($this->$feature);
    }


    public function isFree()
    {
        return $this->price_monthly == 0 && $this->price_yearly == 0;
    }


    public function getYearlyDiscountAttribute()
    {
        if ($this->price_monthly == 0 || $this->price_yearly == 0) {
            return 0;
        }

        $yearlyFromMonthly = $this->price_monthly * 12;
        $discount = (($yearlyFromMonthly - $this->price_yearly) / $yearlyFromMonthly) * 100;

        return round($discount);
    }


    public function getFormattedPriceMonthlyAttribute()
    {
        return '€' . number_format($this->price_monthly, 2);
    }

    public function getFormattedPriceYearlyAttribute()
    {
        return '€' . number_format($this->price_yearly, 2);
    }
}
