<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8 sm:p-12 text-center">
                    <!-- Success Icon -->
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">
                        Onboarding Complete! 🎉
                    </h1>

                    <p class="text-lg text-gray-600 mb-8">
                        You've already completed the onboarding process for {{ $tenant->name }}.
                    </p>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('dashboard') }}" 
                           class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                            Go to Dashboard
                        </a>

                        <a href="{{ route('tenants.edit', $tenant) }}" 
                           class="px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
                            Tenant Settings
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>