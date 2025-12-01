<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h1 class="text-xl font-semibold text-gray-900 mb-4">Create Order</h1>

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <!-- Order Info -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-medium">Number</label>
                        <input type="text" name="number" value="{{ old('number') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-medium">Order Date</label>
                        <input type="date" name="order_date" value="{{ old('order_date', now()->format('Y-m-d')) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-medium">Client</label>
                        <select name="client_id"
                                class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                            <option value="">Select client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium">Validity</label>
                        <input type="date" name="valid_until"
                               value="{{ old('valid_until', now()->addDays(30)->format('Y-m-d')) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-medium">Status</label>
                        <select name="status" class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Order Lines -->
                <h2 class="text-sm font-medium text-gray-700 mb-2">Order Lines</h2>

                <div id="lines">
                    <!-- Linha inicial -->
                    <div class="flex gap-2 mb-2 items-end border-b pb-2">
                        <div class="flex-1">
                            <label class="block text-xs">Item</label>
                            <select name="lines[0][item_id]" class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                                <option value="">Select Item</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->reference }} - {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex-1">
                            <label class="block text-xs">Supplier</label>
                            <select name="lines[0][supplier_id]" class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs">Qty</label>
                            <input type="number" name="lines[0][quantity]" value="1"
                                   class="mt-1 block w-20 border-gray-300 rounded-md text-xs">
                        </div>

                        <div>
                            <label class="block text-xs">Price</label>
                            <input type="number" name="lines[0][price]" value="0" step="0.01"
                                   class="mt-1 block w-24 border-gray-300 rounded-md text-xs">
                        </div>

                        <div>
                            <label class="block text-xs">Cost</label>
                            <input type="number" name="lines[0][cost_price]" value="0" step="0.01"
                                   class="mt-1 block w-24 border-gray-300 rounded-md text-xs">
                        </div>

                        <button type="button" class="text-red-600 text-xs remove-line">Remove</button>
                    </div>
                </div>

                <button type="button" id="add-line" class="mt-2 mb-4 px-3 py-1 bg-gray-200 text-xs rounded">
                    Add Line
                </button>

                <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">
                    Save Order
                </button>
            </form>
        </div>
    </div>

    <!-- Template para novas linhas -->
    <template id="line-template">
        <div class="flex gap-2 mb-2 items-end border-b pb-2">
            <div class="flex-1">
                <label class="block text-xs">Item</label>
                <select name="lines[][item_id]" class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                    <option value="">Select Item</option>
                    @foreach($items as $item)
                        <option value="{{ $item->id }}">{{ $item->reference }} - {{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1">
                <label class="block text-xs">Supplier</label>
                <select name="lines[][supplier_id]" class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs">Qty</label>
                <input type="number" name="lines[][quantity]" value="1"
                       class="mt-1 block w-20 border-gray-300 rounded-md text-xs">
            </div>

            <div>
                <label class="block text-xs">Price</label>
                <input type="number" name="lines[][price]" value="0" step="0.01"
                       class="mt-1 block w-24 border-gray-300 rounded-md text-xs">
            </div>

            <div>
                <label class="block text-xs">Cost</label>
                <input type="number" name="lines[][cost_price]" value="0" step="0.01"
                       class="mt-1 block w-24 border-gray-300 rounded-md text-xs">
            </div>

            <button type="button" class="text-red-600 text-xs remove-line">Remove</button>
        </div>
    </template>

    <!-- JS para adicionar/remover linhas -->
    <script>
        const template = document.getElementById('line-template').content;
        const linesContainer = document.getElementById('lines');
        const addBtn = document.getElementById('add-line');
        let lineIndex = 1; // já existe a linha inicial

        addBtn.addEventListener('click', () => {
            const clone = document.importNode(template, true);

            // Atualiza os names para numerar corretamente
            clone.querySelectorAll('select, input').forEach(input => {
                const name = input.getAttribute('name'); // ex: lines[][quantity]
                input.setAttribute('name', name.replace('[]', `[${lineIndex}]`));
            });

            clone.querySelector('.remove-line').addEventListener('click', e => {
                e.target.closest('div').remove();
            });

            linesContainer.appendChild(clone);
            lineIndex++;
        });

        // Remove linhas existentes
        document.querySelectorAll('.remove-line').forEach(btn => {
            btn.addEventListener('click', e => {
                e.target.closest('div').remove();
            });
        });
    </script>
</x-app-layout>
