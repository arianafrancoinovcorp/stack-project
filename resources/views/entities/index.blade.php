<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Tabs Clients / Suppliers -->
            <div class="flex gap-2 mb-6">
                <a href="{{ route('entities.index', ['type' => 'client']) }}"
                    class="px-3 py-1 text-xs font-medium rounded {{ $type === 'client' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Clients
                </a>
                <a href="{{ route('entities.index', ['type' => 'supplier']) }}"
                    class="px-3 py-1 text-xs font-medium rounded {{ $type === 'supplier' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Suppliers
                </a>
            </div>

            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-xl font-semibold text-gray-900">{{ ucfirst($type) }} ({{ $entities->count() }})</h1>
                <a href="{{ route('entities.create') }}?type={{ $type }}"
                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 transition-colors">
                    Add New
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-3 px-3 py-2 bg-green-50 border-l-2 border-green-500 text-green-700 text-xs rounded-r">
                {{ session('success') }}
            </div>
            @endif
            <form method="GET" action="{{ route('entities.index') }}" class="mb-4 flex gap-2">
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="text" name="search" placeholder="Search..." value="{{ $search }}"
                    class="px-3 py-1 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm">
                <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">Search</button>
            </form>

            <!-- Table -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full table-fixed divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="w-[6%] px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                <th class="w-[12%] px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">NIF</th>
                                <th class="w-[20%] px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="w-[14%] px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                <th class="w-[14%] px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mobile</th>
                                <th class="w-[18%] px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="w-[8%] px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">RGPD</th>
                                <th class="w-[8%] px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="w-[10%] px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($entities as $entity)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-xs text-gray-900 whitespace-nowrap">{{ $entity->id }}</td>
                                <td class="px-3 py-2 text-xs text-gray-900 whitespace-nowrap">{{ $entity->nif }}</td>
                                <td class="px-3 py-2 text-xs text-gray-900 font-medium whitespace-nowrap">{{ $entity->name }}</td>
                                <td class="px-3 py-2 text-xs text-gray-600 whitespace-nowrap">{{ $entity->phone ?: '—' }}</td>
                                <td class="px-3 py-2 text-xs text-gray-600 whitespace-nowrap">{{ $entity->mobile ?: '—' }}</td>
                                <td class="px-3 py-2 text-xs text-gray-600 whitespace-nowrap">{{ $entity->email }}</td>
                                <td class="px-3 py-2 text-xs text-gray-600 whitespace-nowrap">{{ $entity->rgpd_consent ? 'Yes' : 'No' }}</td>
                                <td class="px-3 py-2 text-xs text-gray-600 whitespace-nowrap">{{ ucfirst($entity->status) }}</td>
                                <td class="px-3 py-2 text-xs text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('entities.edit', $entity) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                        <span class="text-gray-300">|</span>
                                        <form action="{{ route('entities.destroy', $entity) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this entity?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-3 py-8 text-center text-xs text-gray-500">
                                    No entities found.
                                    <a href="{{ route('entities.create') }}?type={{ $type }}" class="text-blue-600 hover:text-blue-800 font-medium ml-1">
                                        Add the first
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if(method_exists($entities, 'hasPages') && $entities->hasPages())
            <div class="mt-3">{{ $entities->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>