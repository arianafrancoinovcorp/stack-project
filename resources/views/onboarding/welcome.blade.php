<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Step 1 of 4</span>
                    <span class="text-sm text-gray-500">Welcome</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: 25%"></div>
                </div>
            </div>

            <!-- Welcome Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8 sm:p-12">
                    <!-- Icon -->
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">
                        Welcome to {{ $tenant->name }}!
                    </h1>

                    <!-- Description -->
                    <p class="text-lg text-gray-600 mb-6">
                        Let's get your workspace set up in just a few minutes. We'll help you customize your experience and invite your team.
                    </p>

                    <!-- Features List -->
                    <div class="space-y-4 mb-8">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900">Customize Your Branding</h3>
                                <p class="text-sm text-gray-600">Add your logo and choose your colors</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900">Invite Your Team</h3>
                                <p class="text-sm text-gray-600">Collaborate with your colleagues</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900">Set Your Preferences</h3>
                                <p class="text-sm text-gray-600">Configure timezone, language, and currency</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <form method="POST" action="{{ route('onboarding.welcome') }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                                Let's Get Started
                            </button>
                        </form>

                        <form method="POST" action="{{ route('onboarding.skip') }}">
                            @csrf
                            <button type="submit" class="w-full px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">
                                Skip for Now
                            </button>
                        </form>
                    </div>

                    <p class="text-xs text-gray-500 text-center mt-4">
                        You can always access these settings later
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>