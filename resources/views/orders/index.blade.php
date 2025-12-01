<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-xl font-semibold text-gray-900">Orders ({{ $orders->total() }})</h1>
                <a href="{{ route('orders.create') }}"
                   class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 transition-colors">
                    + New Order
                </a>
            </div>

            <!-- Table Card -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full table-fixed divide-y divide-gray-200 text-xs">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Number</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Client</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Validity</th>
                                <th class="px-3 py-2 text-right font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-3 py-2 text-right font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 whitespace-nowrap">{{ $order->order_date }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">{{ $order->number }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">{{ $order->client->name }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">{{ $order->valid_until }}</td>
                                    <td class="px-3 py-2 text-right whitespace-nowrap">{{ number_format($order->total, 2) }} €</td>
                                    <td class="px-3 py-2 whitespace-nowrap">{{ ucfirst($order->status) }}</td>
                                    <td class="px-3 py-2 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('orders.edit', $order) }}" class="text-blue-600 hover:text-blue-800 text-xs">Edit</a>
                                            <a href="{{ route('orders.pdf', $order) }}" class="text-green-600 hover:text-green-800 text-xs">PDF</a>
                                            @if($order->status === 'closed')
                                                <form action="{{ route('orders.convertToSupplierOrders', $order) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button class="text-orange-600 hover:text-orange-800 text-xs">
                                                        Convert
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-3 py-8 text-center text-xs text-gray-500">
                                        No orders found.
                                        <a href="{{ route('orders.create') }}" class="text-blue-600 hover:text-blue-800 font-medium ml-1">
                                            Add the first
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="mt-3 px-3 py-2">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
