<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-xl font-semibold text-gray-900">
                    Contacts ({{ $contacts->total() }})
                </h1>
                <a href="{{ route('contacts.create') }}"
                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded 
                           hover:bg-blue-700 transition-colors">
                    Add New
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-3 px-3 py-2 bg-green-50 border-l-2 border-green-500 text-green-700 text-xs rounded-r">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filters -->
            <form method="GET" class="mb-4 flex gap-2">

                <select name="entity_id"
                    class="px-3 py-1 pr-8 rounded border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Entities</option>
                    @foreach($entities as $entity)
                        <option value="{{ $entity->id }}" {{ request('entity_id') == $entity->id ? 'selected' : '' }}>
                            {{ $entity->name }}
                        </option>
                    @endforeach
                </select>

                <select name="function_id"
                    class="px-3 py-1 pr-8 rounded border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Functions</option>
                    @foreach($functions as $function)
                        <option value="{{ $function->id }}" {{ request('function_id') == $function->id ? 'selected' : '' }}>
                            {{ $function->name }}
                        </option>
                    @endforeach
                </select>

                <select name="status"
                    class="px-3 py-1 pr-8 rounded border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>

                <button type="submit"
                    class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                    Filter
                </button>
            </form>

            <!-- Table -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full table-fixed divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="w-[22%] px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="w-[14%] px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Function</th>
                                <th class="w-[18%] px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Entity</th>
                                <th class="w-[14%] px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                <th class="w-[18%] px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="w-[14%] px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($contacts as $contact)
                                <tr class="hover:bg-gray-50">

                                    <!-- Name -->
                                    <td class="px-3 py-2 text-xs text-gray-900 whitespace-nowrap">
                                        {{ $contact->first_name }} {{ $contact->last_name }}
                                    </td>

                                    <!-- Function -->
                                    <td class="px-3 py-2 text-xs text-gray-700 whitespace-nowrap">
                                        {{ $contact->function->name ?? '—' }}
                                    </td>

                                    <!-- Entity -->
                                    <td class="px-3 py-2 text-xs text-gray-700 whitespace-nowrap">
                                        {{ $contact->entity->name }}
                                    </td>

                                    <!-- Phone -->
                                    <td class="px-3 py-2 text-xs text-gray-700 whitespace-nowrap">
                                        {{ $contact->phone ?: $contact->mobile ?: '—' }}
                                    </td>

                                    <!-- Email -->
                                    <td class="px-3 py-2 text-xs text-gray-700 whitespace-nowrap">
                                        {{ $contact->email }}
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-3 py-2 text-xs text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-3">

                                            <!-- Edit -->
                                            <a href="{{ route('contacts.edit', $contact) }}"
                                               class="text-blue-600 hover:text-blue-800 font-medium">
                                                Edit
                                            </a>

                                            <!-- Delete -->
                                            <form action="{{ route('contacts.destroy', $contact) }}" method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this contact?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-800 font-medium">
                                                    Delete
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-3 py-8 text-center text-xs text-gray-500">
                                        No contacts found.
                                        <a href="{{ route('contacts.create') }}"
                                           class="text-blue-600 hover:text-blue-800 font-medium ml-1">
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
            @if($contacts->hasPages())
                <div class="mt-3">
                    {{ $contacts->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
