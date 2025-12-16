<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Subscription & Billing</h1>
                <p class="mt-1 text-sm text-gray-600">Manage your subscription and view usage</p>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-r">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 px-4 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-r">
                {{ session('error') }}
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left Column: Current Plan & Usage -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Current Plan Card -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-8 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    @if ($plan)
                                    <h2 class="text-2xl font-bold mb-1">{{ $plan->name }} Plan</h2>
                                    <p class="text-blue-100">{{ $plan->description }}</p>
                                    @else
                                    <h2 class="text-2xl font-bold mb-1">No Active Plan</h2>
                                    <p class="text-blue-100">You are currently not subscribed to any plan.</p>
                                    @endif
                                </div>

                                @if($subscription && $subscription->isOnTrial())
                                <span class="px-4 py-2 bg-yellow-400 text-yellow-900 rounded-full text-sm font-semibold">
                                    Trial: {{ $subscription->trialDaysRemaining() }} days left
                                </span>
                                @endif
                            </div>

                            @if($subscription)
                            <div class="mt-6 grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-blue-200 text-sm">Billing Cycle</p>
                                    <p class="text-xl font-semibold">{{ ucfirst($subscription->billing_cycle) }}</p>
                                </div>
                                <div>
                                    <p class="text-blue-200 text-sm">Amount</p>
                                    <p class="text-xl font-semibold">€{{ number_format($subscription->amount, 2) }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        @if($subscription)
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">
                                    @if($subscription->isOnTrial())
                                    Trial ends: {{ $subscription->trial_ends_at?->format('M d, Y') ?? 'N/A' }}
                                    @else
                                    Next payment: {{ $subscription->next_payment_at?->format('M d, Y') ?? 'N/A' }}
                                    @endif
                                </span>
                                <span class="px-3 py-1 rounded-full text-xs font-medium
            {{ $subscription->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
            {{ $subscription->status === 'trialing' ? 'bg-blue-100 text-blue-800' : '' }}
            {{ $subscription->status === 'canceled' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($subscription->status) }}
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Usage Stats -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Current Usage</h3>

                        <div class="space-y-6">
                            @foreach(['users','entities','proposals','orders'] as $key)
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">{{ ucfirst($key) }}{{ in_array($key,['proposals','orders']) ? ' (this month)' : '' }}</span>
                                    <span class="text-sm text-gray-600">
                                        {{ $usage[$key] }} / {{ $limits[$key] ?? '∞' }}
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="{{ match($key){
                                        'users'=>'bg-blue-600',
                                        'entities'=>'bg-green-600',
                                        'proposals'=>'bg-purple-600',
                                        'orders'=>'bg-orange-600',
                                        default=>'bg-gray-600'
                                    } }} h-2 rounded-full" style="width: {{ $percentages[$key] }}%"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Warning if approaching limits -->
                        @php
                        $warnings = [];
                        foreach(['users','entities','proposals','orders'] as $key){
                        if(isset($limits[$key]) && $usage[$key] >= $limits[$key]*0.8){
                        $warnings[] = $key;
                        }
                        }
                        @endphp

                        @if(count($warnings) > 0)
                        <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-r">
                            <div class="flex">
                                <svg class="h-5 w-5 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-yellow-800">Approaching limits</p>
                                    <p class="text-sm text-yellow-700 mt-1">
                                        You're approaching your limit for: {{ implode(', ', $warnings) }}.
                                        <a href="{{ route('plans.index') }}" class="underline font-semibold">Upgrade your plan</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Change History -->
                    @if($changes->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Change History</h3>

                        <div class="space-y-4">
                            @foreach($changes as $change)
                            <div class="flex items-start pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center
                                    {{ $change->action === 'created' ? 'bg-blue-100' : '' }}
                                    {{ $change->action === 'upgraded' ? 'bg-green-100' : '' }}
                                    {{ $change->action === 'downgraded' ? 'bg-orange-100' : '' }}
                                    {{ $change->action === 'canceled' ? 'bg-red-100' : '' }}
                                    {{ $change->action === 'renewed' ? 'bg-purple-100' : '' }}">
                                    <!-- Icons omitted for brevity, can reuse the same SVGs -->
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ ucfirst($change->action) }}
                                        @if($change->fromPlan && $change->toPlan)
                                        from {{ $change->fromPlan->name }} to {{ $change->toPlan->name }}
                                        @elseif($change->toPlan)
                                        {{ $change->toPlan->name }}
                                        @endif
                                    </p>
                                    @if($change->notes)
                                    <p class="text-xs text-gray-600 mt-1">{{ $change->notes }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $change->created_at->format('M d, Y H:i') }} by {{ $change->user->name }}
                                    </p>
                                </div>
                                @if($change->amount > 0)
                                <div class="text-sm font-semibold text-gray-900">
                                    €{{ number_format($change->amount, 2) }}
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>

                <!-- Right Column: Actions & Features -->
                <div class="space-y-6">

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>

                        <div class="space-y-3">
                            <a href="{{ route('plans.index') }}" class="block w-full px-4 py-3 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-100 transition text-center">
                                View All Plans
                            </a>

                            @if($subscription && $subscription->isActive() && !$subscription->isCanceled())
                            <button onclick="document.getElementById('cancel-modal').classList.remove('hidden')"
                                class="block w-full px-4 py-3 bg-red-50 text-red-700 rounded-lg text-sm font-medium hover:bg-red-100 transition text-center">
                                Cancel Subscription
                            </button>
                            @endif

                            @if($subscription && $subscription->isCanceled())
                            <form method="POST" action="{{ route('subscriptions.resume') }}">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-3 bg-green-50 text-green-700 rounded-lg text-sm font-medium hover:bg-green-100 transition text-center">
                                    Resume Subscription
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>

                    <!-- Plan Features -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Features</h3>

                        <ul class="space-y-3">
                            @if($plan && $plan->features)
                            @foreach($plan->features as $feature)
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-700">{{ $feature }}</span>
                            </li>
                            @endforeach
                            @else
                            <li class="text-sm text-gray-500">No features available.</li>
                            @endif
                        </ul>
                    </div>

                    <!-- Support -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg border border-blue-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Need Help?</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Contact our support team if you have any questions about your subscription.
                        </p>
                        <a href="mailto:support@example.com" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                            support@example.com
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Cancel Modal -->
    <div id="cancel-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Cancel Subscription</h3>
                <p class="text-sm text-gray-600 mb-6">
                    Are you sure you want to cancel your subscription? You can choose to cancel immediately or at the end of your billing period.
                </p>

                <div class="space-y-3">
                    <form method="POST" action="{{ route('subscriptions.cancel') }}">
                        @csrf
                        <input type="hidden" name="immediately" value="0">
                        <button type="submit" class="w-full px-4 py-3 bg-orange-600 text-white rounded-lg text-sm font-medium hover:bg-orange-700 transition">
                            Cancel at End of Period
                        </button>
                    </form>

                    <form method="POST" action="{{ route('subscriptions.cancel') }}">
                        @csrf
                        <input type="hidden" name="immediately" value="1">
                        <button type="submit" class="w-full px-4 py-3 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition">
                            Cancel Immediately
                        </button>
                    </form>

                    <button onclick="document.getElementById('cancel-modal').classList.add('hidden')"
                        class="w-full px-4 py-3 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 transition">
                        Keep Subscription
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>