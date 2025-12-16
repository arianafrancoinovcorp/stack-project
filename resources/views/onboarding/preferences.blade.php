<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Step 4 of 4</span>
                    <span class="text-sm text-gray-500">Preferences</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: 100%"></div>
                </div>
            </div>

            <!-- Preferences Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8 sm:p-12">
                    <!-- Icon -->
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        Set Your Preferences
                    </h1>
                    <p class="text-gray-600 mb-8">
                        Almost done! Configure your workspace settings.
                    </p>

                    <!-- Form -->
                    <form method="POST" action="{{ route('onboarding.preferences') }}">
                        @csrf

                        <!-- Timezone -->
                        <div class="mb-6">
                            <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">
                                Timezone
                            </label>
                            <select name="timezone" 
                                    id="timezone"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="UTC" {{ old('timezone', $tenant->settings['timezone'] ?? 'UTC') == 'UTC' ? 'selected' : '' }}>UTC (Coordinated Universal Time)</option>
                                <option value="Europe/Lisbon" {{ old('timezone', $tenant->settings['timezone'] ?? '') == 'Europe/Lisbon' ? 'selected' : '' }}>Europe/Lisbon (Portugal)</option>
                                <option value="Europe/London" {{ old('timezone', $tenant->settings['timezone'] ?? '') == 'Europe/London' ? 'selected' : '' }}>Europe/London (UK)</option>
                                <option value="Europe/Paris" {{ old('timezone', $tenant->settings['timezone'] ?? '') == 'Europe/Paris' ? 'selected' : '' }}>Europe/Paris (France)</option>
                                <option value="Europe/Berlin" {{ old('timezone', $tenant->settings['timezone'] ?? '') == 'Europe/Berlin' ? 'selected' : '' }}>Europe/Berlin (Germany)</option>
                                <option value="America/New_York" {{ old('timezone', $tenant->settings['timezone'] ?? '') == 'America/New_York' ? 'selected' : '' }}>America/New_York (US Eastern)</option>
                                <option value="America/Los_Angeles" {{ old('timezone', $tenant->settings['timezone'] ?? '') == 'America/Los_Angeles' ? 'selected' : '' }}>America/Los_Angeles (US Pacific)</option>
                                <option value="America/Sao_Paulo" {{ old('timezone', $tenant->settings['timezone'] ?? '') == 'America/Sao_Paulo' ? 'selected' : '' }}>America/Sao_Paulo (Brazil)</option>
                                <option value="Asia/Dubai" {{ old('timezone', $tenant->settings['timezone'] ?? '') == 'Asia/Dubai' ? 'selected' : '' }}>Asia/Dubai (UAE)</option>
                                <option value="Asia/Tokyo" {{ old('timezone', $tenant->settings['timezone'] ?? '') == 'Asia/Tokyo' ? 'selected' : '' }}>Asia/Tokyo (Japan)</option>
                            </select>
                            @error('timezone')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Language -->
                        <div class="mb-6">
                            <label for="language" class="block text-sm font-medium text-gray-700 mb-2">
                                Language
                            </label>
                            <select name="language" 
                                    id="language"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="en" {{ old('language', $tenant->settings['language'] ?? 'en') == 'en' ? 'selected' : '' }}>English</option>
                                <option value="pt" {{ old('language', $tenant->settings['language'] ?? '') == 'pt' ? 'selected' : '' }}>Português</option>
                                <option value="es" {{ old('language', $tenant->settings['language'] ?? '') == 'es' ? 'selected' : '' }}>Español</option>
                                <option value="fr" {{ old('language', $tenant->settings['language'] ?? '') == 'fr' ? 'selected' : '' }}>Français</option>
                                <option value="de" {{ old('language', $tenant->settings['language'] ?? '') == 'de' ? 'selected' : '' }}>Deutsch</option>
                            </select>
                            @error('language')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Currency -->
                        <div class="mb-8">
                            <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">
                                Currency
                            </label>
                            <select name="currency" 
                                    id="currency"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="EUR" {{ old('currency', $tenant->settings['currency'] ?? 'EUR') == 'EUR' ? 'selected' : '' }}>EUR (€) - Euro</option>
                                <option value="USD" {{ old('currency', $tenant->settings['currency'] ?? '') == 'USD' ? 'selected' : '' }}>USD ($) - US Dollar</option>
                                <option value="GBP" {{ old('currency', $tenant->settings['currency'] ?? '') == 'GBP' ? 'selected' : '' }}>GBP (£) - British Pound</option>
                                <option value="BRL" {{ old('currency', $tenant->settings['currency'] ?? '') == 'BRL' ? 'selected' : '' }}>BRL (R$) - Brazilian Real</option>
                                <option value="JPY" {{ old('currency', $tenant->settings['currency'] ?? '') == 'JPY' ? 'selected' : '' }}>JPY (¥) - Japanese Yen</option>
                            </select>
                            @error('currency')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Success Message Preview -->
                        <div class="mb-8 p-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-2 border-green-200">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <h3 class="text-sm font-semibold text-green-900">You're all set!</h3>
                                    <p class="text-sm text-green-700 mt-1">
                                        After completing this step, you'll be redirected to your dashboard and can start using all features.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t">
                            <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 transition shadow-lg">
                                Complete Setup 🎉
                            </button>

                            <a href="{{ route('onboarding.skip') }}" 
                               onclick="event.preventDefault(); document.getElementById('skip-form').submit();"
                               class="px-6 py-3 text-gray-600 font-medium text-center hover:text-gray-800 transition">
                                Skip
                            </a>
                        </div>
                    </form>

                    <form id="skip-form" method="POST" action="{{ route('onboarding.skip') }}" class="hidden">
                        @csrf
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>