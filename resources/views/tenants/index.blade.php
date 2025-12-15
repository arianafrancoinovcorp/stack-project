<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">My Tenants</h1>
                    <p class="mt-1 text-sm text-gray-600">Manage your workspaces and organizations</p>
                </div>
                <a href="{{ route('tenants.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create New Tenant
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-r">
                {{ session('success') }}
            </div>
            @endif

            @if(session('warning'))
            <div class="mb-6 px-4 py-3 bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 text-sm rounded-r">
                {{ session('warning') }}
            </div>
            @endif

            <!-- Tenants Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($tenants as $tenant)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="p-6">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $tenant->name }}</h3>
                                <p class="text-xs text-gray-500 mt-1">{{ $tenant->slug }}</p>
                            </div>
                            @if($tenant->pivot->role === 'owner')
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">
                                Owner
                            </span>
                            @elseif($tenant->pivot->role === 'admin')
                            <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs font-medium rounded">
                                Admin
                            </span>
                            @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded">
                                Member
                            </span>
                            @endif
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            @if($tenant->status === 'active')
                            <span class="inline-flex items-center text-xs text-green-700">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                Active
                            </span>
                            @elseif($tenant->status === 'trial')
                            <span class="inline-flex items-center text-xs text-yellow-700">
                                <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                Trial
                            </span>
                            @elseif($tenant->status === 'suspended')
                            <span class="inline-flex items-center text-xs text-red-700">
                                <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                Suspended
                            </span>
                            @endif
                        </div>

                        <!-- Stats -->
                        <div class="flex items-center justify-between text-xs text-gray-600 mb-4 pb-4 border-b">
                            <div>
                                <p class="text-gray-500">Created</p>
                                <p class="font-medium">{{ $tenant->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-500">Members</p>
                                <p class="font-medium">{{ $tenant->users->count() }}</p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2">
                            @if(session('tenant_id') === $tenant->id)
                            <button disabled
                                    class="flex-1 px-3 py-2 bg-gray-100 text-gray-500 rounded text-sm cursor-not-allowed">
                                Current Tenant
                            </button>
                            @else
                            <a href="{{ route('tenants.switch', $tenant->id) }}"
                               class="flex-1 px-3 py-2 bg-blue-50 text-blue-700 rounded text-sm hover:bg-blue-100 text-center">
                                Switch
                            </a>
                            @endif

                            @if(in_array($tenant->pivot->role, ['owner', 'admin']))
                            <a href="{{ route('tenants.edit', $tenant->id) }}"
                               class="px-3 py-2 bg-gray-100 text-gray-700 rounded text-sm hover:bg-gray-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No tenants</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new tenant.</p>
                    <div class="mt-6">
                        <a href="{{ route('tenants.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create Tenant
                        </a>
                    </div>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>