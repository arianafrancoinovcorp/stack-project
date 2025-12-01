<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-4">
                <h1 class="text-xl font-semibold text-gray-900">Business Proposals ({{ $proposals->count() }})</h1>
                <a href="{{ route('proposals.create') }}"
                   class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 transition-colors">
                    Add New
                </a>
            </div>

            @if(session('success'))
                <div class="mb-3 px-3 py-2 bg-green-50 border-l-2 border-green-500 text-green-700 text-xs rounded-r">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full table-fixed divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Number</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Valid Until</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($proposals as $proposal)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 text-xs text-gray-900">{{ $proposal->number }}</td>
                                <td class="px-3 py-2 text-xs text-gray-700">{{ $proposal->proposal_date }}</td>
                                <td class="px-3 py-2 text-xs text-gray-900">{{ $proposal->client->name }}</td>
                                <td class="px-3 py-2 text-xs text-gray-700">{{ $proposal->valid_until }}</td>
                                <td class="px-3 py-2 text-xs text-gray-700">{{ $proposal->total }}€</td>
                                <td class="px-3 py-2 text-xs text-gray-700">{{ ucfirst($proposal->status) }}</td>
                                <td class="px-3 py-2 text-xs text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('proposals.edit', $proposal) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                        <form action="{{ route('proposals.destroy', $proposal) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this proposal?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-3 py-8 text-center text-xs text-gray-500">
                                    No proposals found.
                                    <a href="{{ route('proposals.create') }}" class="text-blue-600 hover:text-blue-800 font-medium ml-1">
                                        Add the first
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($proposals->hasPages())
                <div class="mt-3">{{ $proposals->links() }}</div>
            @endif

        </div>
    </div>
</x-app-layout>
