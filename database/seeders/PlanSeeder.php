<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'description' => 'Perfect for getting started',
                'price_monthly' => 0,
                'price_yearly' => 0,
                'max_users' => 1,
                'max_entities' => 10,
                'max_proposals' => 5,
                'max_orders' => 5,
                'max_storage_mb' => 100,
                'features' => [
                    'Basic CRM features',
                    '1 user',
                    '10 entities',
                    '5 proposals per month',
                    '5 orders per month',
                    '100 MB storage',
                    'Email support'
                ],
                'trial_days' => 0,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1
            ],
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'For small teams and growing businesses',
                'price_monthly' => 29,
                'price_yearly' => 290, // 2 months
                'max_users' => 5,
                'max_entities' => 100,
                'max_proposals' => 50,
                'max_orders' => 50,
                'max_storage_mb' => 1000,
                'features' => [
                    'All Free features',
                    'Up to 5 users',
                    '100 entities',
                    '50 proposals per month',
                    '50 orders per month',
                    '1 GB storage',
                    'Priority email support',
                    'Advanced reporting'
                ],
                'trial_days' => 14,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 2
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'For established businesses with advanced needs',
                'price_monthly' => 79,
                'price_yearly' => 790, // 2 months free
                'max_users' => 20,
                'max_entities' => 500,
                'max_proposals' => null, // unlimited
                'max_orders' => null, // unlimited
                'max_storage_mb' => 10000,
                'features' => [
                    'All Starter features',
                    'Up to 20 users',
                    '500 entities',
                    'Unlimited proposals',
                    'Unlimited orders',
                    '10 GB storage',
                    'Priority support (24/7)',
                    'Custom branding',
                    'API access',
                    'Advanced integrations'
                ],
                'trial_days' => 14,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Custom solutions for large organizations',
                'price_monthly' => 199,
                'price_yearly' => 1990, // 2 months free
                'max_users' => null, // unlimited
                'max_entities' => null, // unlimited
                'max_proposals' => null, // unlimited
                'max_orders' => null, // unlimited
                'max_storage_mb' => null, // unlimited
                'features' => [
                    'All Professional features',
                    'Unlimited users',
                    'Unlimited entities',
                    'Unlimited proposals & orders',
                    'Unlimited storage',
                    'Dedicated account manager',
                    'Custom development',
                    'SLA guarantee',
                    'White-label options',
                    'Advanced security features'
                ],
                'trial_days' => 30,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 4
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}