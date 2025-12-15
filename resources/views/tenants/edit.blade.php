<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Tenant Settings</h1>
                <p class="mt-1 text-sm text-gray-600">Manage {{ $tenant->name }} configuration</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-r">
                {{ session('success') }}
            </div>
            @endif

            <!-- Tabs -->
            <div class="mb-6 border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <a href="#" class="border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        General
                    </a>
                    <span class="border-transparent text-gray-400 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm cursor-not-allowed">
                        Members (Coming soon)
                    </span>
                    <span class="border-transparent text-gray-400 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm cursor-not-allowed">
                        Billing (Coming soon)
                    </span>
                </nav>
            </div>

            <!-- Form Card -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                <form method="POST" action="{{ route('tenants.update', $tenant) }}">
                    @csrf
                    @method('PUT')

                    <!-- Tenant Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Tenant Name *
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name"
                               value="{{ old('name', $tenant->name) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               required>
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug (read-only) -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Slug
                        </label>
                        <input type="text" 
                               value="{{ $tenant->slug }}"
                               class="w-full border-gray-300 rounded-md shadow-sm bg-gray-50"
                               disabled>
                        <p class="mt-1 text-xs text-gray-500">
                            The slug is automatically generated and cannot be changed.
                        </p>
                    </div>

                    <!-- Info -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-md border border-gray-200">
                        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-xs font-medium text-gray-500">Owner</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $tenant->owner->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500">Created</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $tenant->created_at->format('M d, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-sm">
                                    <span class="px-2 py-1 text-xs font-medium rounded
                                        {{ $tenant->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $tenant->status === 'trial' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $tenant->status === 'suspended' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($tenant->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500">Members</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $tenant->users->count() }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                        <a href="{{ route('tenants.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm hover:bg-gray-300">
                            Back
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>