<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h1 class="text-xl font-semibold mb-4">Edit Order</h1>

            <form action="{{ route('orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs">Number</label>
                        <input type="text" name="number" value="{{ $order->number }}"
                               class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                    </div>

                    <div>
                        <label class="block text-xs">Order Date</label>
                        <input type="date" name="order_date" value="{{ $order->order_date }}"
                               class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                    </div>

                    <div>
                        <label class="block text-xs">Client</label>
                        <select name="client_id"
                                class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ $order->client_id == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs">Validity</label>
                        <input type="date" name="valid_until" value="{{ $order->valid_until }}"
                               class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                    </div>

                    <div>
                        <label class="block text-xs">Status</label>
                        <select name="status"
                                class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                            <option value="draft" {{ $order->status === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="closed" {{ $order->status === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">

                <h2 class="text-sm font-medium text-gray-700 mb-2">Order Lines</h2>

                <div id="lines">
                    @foreach($order->lines as $line)
                        <div class="flex gap-2 mb-2 items-end border-b pb-2">

                            <div class="flex-1">
                                <label class="block text-xs">Item</label>
                                <select name="lines[][item_id]" class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}" {{ $line->item_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->reference }} - {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex-1">
                                <label class="block text-xs">Supplier</label>
                                <select name="lines[][supplier_id]" class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ $line->supplier_id == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs">Qty</label>
                                <input type="number" name="lines[][quantity]" value="{{ $line->quantity }}"
                                       class="mt-1 block w-20 border-gray-300 rounded-md text-xs">
                            </div>

                            <div>
                                <label class="block text-xs">Price</label>
                                <input type="number" name="lines[][price]" value="{{ $line->price }}"
                                       step="0.01" class="mt-1 block w-24 border-gray-300 rounded-md text-xs">
                            </div>

                            <div>
                                <label class="block text-xs">Cost</label>
                                <input type="number" name="lines[][cost_price]" value="{{ $line->cost_price }}"
                                       step="0.01" class="mt-1 block w-24 border-gray-300 rounded-md text-xs">
                            </div>

                            <button type="button" class="text-red-600 text-xs remove-line">Remove</button>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="add-line"
                        class="mt-2 mb-4 px-3 py-1 bg-gray-200 text-xs rounded">
                    Add Line
                </button>

                <button type="submit"
                        class="px-3 py-2 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">
                    Update Order
                </button>
            </form>
        </div>
    </div>

    @include('orders.partials.lines-js')
</x-app-layout>
