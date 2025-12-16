<x-app-layout>
    <div class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Choose Your Plan</h1>
                <p class="text-xl text-gray-600">Select the perfect plan for your business needs</p>
                
                @if($currentPlan)
                <div class="mt-4">
                    <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                        Current Plan: {{ $currentPlan->name }}
                    </span>
                </div>
                @endif
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-r max-w-4xl mx-auto">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 px-4 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-r max-w-4xl mx-auto">
                {{ session('error') }}
            </div>
            @endif

            <!-- Plans Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($plans as $plan)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition hover:scale-105 {{ $plan->is_featured ? 'ring-4 ring-blue-500' : '' }}">
                    
                    @if($plan->is_featured)
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-center py-2 text-sm font-semibold">
                        MOST POPULAR
                    </div>
                    @endif

                    <div class="p-8">
                        <!-- Plan Name -->
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h3>
                        <p class="text-gray-600 text-sm mb-6">{{ $plan->description }}</p>

                        <!-- Pricing -->
                        <div class="mb-6">
                            @if($plan->isFree())
                                <div class="text-4xl font-bold text-gray-900">Free</div>
                                <div class="text-sm text-gray-500">Forever</div>
                            @else
                                <div class="flex items-baseline mb-2">
                                    <span class="text-4xl font-bold text-gray-900">{{ $plan->formatted_price_monthly }}</span>
                                    <span class="text-gray-600 ml-2">/month</span>
                                </div>
                                @if($plan->yearly_discount > 0)
                                <div class="text-sm text-green-600">
                                    Save {{ $plan->yearly_discount }}% with yearly billing
                                </div>
                                @endif
                            @endif
                        </div>

                        <!-- Features -->
                        <ul class="space-y-3 mb-8">
                            @foreach($plan->features as $feature)
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-700">{{ $feature }}</span>
                            </li>
                            @endforeach
                        </ul>

                        <!-- CTA Button -->
                        @if($currentPlan && $currentPlan->id === $plan->id)
                        <button disabled class="w-full py-3 px-6 bg-gray-200 text-gray-500 rounded-lg font-medium cursor-not-allowed">
                            Current Plan
                        </button>
                        @elseif(!$currentPlan || $plan->price_monthly == 0)
                        <form method="POST" action="{{ route('subscriptions.subscribe', $plan) }}">
                            @csrf
                            <input type="hidden" name="billing_cycle" value="monthly">
                            <button type="submit" class="w-full py-3 px-6 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                                Get Started
                            </button>
                        </form>
                        @else
                        <a href="{{ route('plans.show', $plan) }}" class="block w-full py-3 px-6 text-center bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                            Select Plan
                        </a>
                        @endif

                        @if($plan->trial_days > 0 && !$plan->isFree())
                        <p class="text-center text-xs text-gray-500 mt-3">
                            {{ $plan->trial_days }}-day free trial
                        </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-16 text-center">
                <p class="text-gray-600">
                    Need help choosing? <a href="{{ route('subscriptions.dashboard') }}" class="text-blue-600 hover:underline">View your current usage</a>
                </p>
            </div>

        </div>
    </div>
</x-app-layout>