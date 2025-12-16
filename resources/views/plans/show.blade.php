<x-app-layout>
    <div class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('plans.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Plans
                </a>
            </div>

            <!-- Plan Details Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-12 text-white">
                    <h1 class="text-4xl font-bold mb-2">{{ $plan->name }}</h1>
                    <p class="text-xl opacity-90">{{ $plan->description }}</p>
                </div>

                <div class="p-8">
                    <!-- Pricing Options -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Choose Billing Cycle</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Monthly -->
                            <div class="border-2 border-gray-200 rounded-lg p-6 hover:border-blue-500 transition cursor-pointer" onclick="selectBilling('monthly')">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Monthly</h3>
                                        <p class="text-sm text-gray-600">Pay month by month</p>
                                    </div>
                                    <input type="radio" name="billing_cycle" value="monthly" class="w-5 h-5 text-blue-600" checked>
                                </div>
                                <div class="text-3xl font-bold text-gray-900">
                                    {{ $plan->formatted_price_monthly }}
                                    <span class="text-lg font-normal text-gray-600">/month</span>
                                </div>
                            </div>

                            <!-- Yearly -->
                            <div class="border-2 border-gray-200 rounded-lg p-6 hover:border-blue-500 transition cursor-pointer relative" onclick="selectBilling('yearly')">
                                @if($plan->yearly_discount > 0)
                                <div class="absolute -top-3 -right-3 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    SAVE {{ $plan->yearly_discount }}%
                                </div>
                                @endif
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Yearly</h3>
                                        <p class="text-sm text-gray-600">Best value</p>
                                    </div>
                                    <input type="radio" name="billing_cycle" value="yearly" class="w-5 h-5 text-blue-600">
                                </div>
                                <div class="text-3xl font-bold text-gray-900">
                                    {{ $plan->formatted_price_yearly }}
                                    <span class="text-lg font-normal text-gray-600">/year</span>
                                </div>
                                <p class="text-sm text-green-600 mt-2">
                                    €{{ number_format($plan->price_monthly * 12 - $plan->price_yearly, 2) }} saved per year
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">What's Included</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($plan->features as $feature)
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-700">{{ $feature }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Limits -->
                    <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Plan Limits</h3>
                        <dl class="grid grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm text-gray-600">Users</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $plan->max_users ?? 'Unlimited' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-600">Entities</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $plan->max_entities ?? 'Unlimited' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-600">Proposals/month</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $plan->max_proposals ?? 'Unlimited' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-600">Orders/month</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $plan->max_orders ?? 'Unlimited' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-600">Storage</dt>
                                <dd class="text-lg font-semibold text-gray-900">
                                    {{ $plan->max_storage_mb ? ($plan->max_storage_mb >= 1000 ? ($plan->max_storage_mb / 1000) . ' GB' : $plan->max_storage_mb . ' MB') : 'Unlimited' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-600">Trial Period</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $plan->trial_days }} days</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Actions -->
                    <form id="subscribe-form" method="POST" action="">
                        @csrf
                        <input type="hidden" name="billing_cycle" id="billing_cycle_input" value="monthly">
                        
                        <div class="flex gap-4">
                            @if($currentPlan && $currentPlan->id === $plan->id)
                            <button type="button" disabled class="flex-1 py-4 px-6 bg-gray-200 text-gray-500 rounded-lg font-medium text-lg cursor-not-allowed">
                                Current Plan
                            </button>
                            @elseif(!$currentPlan)
                            <button type="submit" class="flex-1 py-4 px-6 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-medium text-lg hover:from-blue-700 hover:to-indigo-700 transition shadow-lg">
                                Subscribe Now
                            </button>
                            @elseif($plan->price_monthly > $currentPlan->price_monthly)
                            <button type="submit" class="flex-1 py-4 px-6 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg font-medium text-lg hover:from-green-700 hover:to-emerald-700 transition shadow-lg">
                                Upgrade Now
                            </button>
                            @else
                            <button type="submit" class="flex-1 py-4 px-6 bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-lg font-medium text-lg hover:from-orange-700 hover:to-red-700 transition shadow-lg">
                                Downgrade (Next Cycle)
                            </button>
                            @endif
                        </div>
                    </form>

                    @if($plan->trial_days > 0 && !$currentPlan)
                    <p class="text-center text-sm text-gray-600 mt-4">
                        🎉 Start with a {{ $plan->trial_days }}-day free trial. No credit card required.
                    </p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <script>
        function selectBilling(cycle) {
            document.querySelectorAll('input[name="billing_cycle"]').forEach(radio => {
                radio.checked = radio.value === cycle;
            });
            
            document.getElementById('billing_cycle_input').value = cycle;

            const form = document.getElementById('subscribe-form');
            const currentPlan = @json($currentPlan);
            const planId = {{ $plan->id }};

            if (!currentPlan) {
                form.action = "{{ route('subscriptions.subscribe', $plan) }}";
            } else if ({{ $plan->price_monthly }} > currentPlan.price_monthly) {
                form.action = "{{ route('subscriptions.upgrade', $plan) }}";
            } else {
                form.action = "{{ route('subscriptions.downgrade', $plan) }}";
            }
        }

        selectBilling('monthly');
    </script>
</x-app-layout>