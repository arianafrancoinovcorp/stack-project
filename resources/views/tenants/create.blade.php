<x-app-layout>
    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Create New Tenant</h1>
                <p class="mt-1 text-sm text-gray-600">Set up a new workspace or organization</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                <form method="POST" action="{{ route('tenants.store') }}">
                    @csrf

                    <!-- Tenant Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Tenant Name *
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name"
                               value="{{ old('name') }}"
                               placeholder="e.g., My Company, ACME Corp"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               required
                               autofocus>
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            This will be the name of your workspace. You can change it later.
                        </p>
                    </div>

                    <!-- Info Box -->
                    <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-r">
                        <div class="flex">
                            <svg class="h-5 w-5 text-blue-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    You'll be able to invite team members and configure your tenant after creation.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end items-center pt-4 border-t border-gray-200">
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                            Create Tenant
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>