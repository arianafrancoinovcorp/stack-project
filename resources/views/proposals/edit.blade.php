<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h1 class="text-xl font-semibold text-gray-900 mb-4">Edit Business Proposal</h1>

            <form action="{{ route('proposals.update', $proposal) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700">Number</label>
                        <input type="text" name="number" value="{{ old('number', $proposal->number) }}" class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700">Proposal Date</label>
                        <input type="date" name="proposal_date" value="{{ old('proposal_date', $proposal->proposal_date) }}" class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700">Client</label>
                        <select name="client_id" id="client_id"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select client</option>
                                @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                                @endforeach
                            </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700">Valid Until</label>
                        <input type="date" name="valid_until" value="{{ old('valid_until', $proposal->valid_until) }}" class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full border-gray-300 rounded-md text-xs">
                            <option value="draft" {{ $proposal->status === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="closed" {{ $proposal->status === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">

                <h2 class="text-sm font-medium text-gray-700 mb-2">Proposal Lines</h2>

                <div id="lines">
                    <template id="line-template">
                        <div class="flex gap-2 mb-2 items-end">
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
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs">Quantity</label>
                                <input type="number" name="lines[][quantity]" value="1" class="mt-1 block w-20 border-gray-300 rounded-md text-xs">
                            </div>

                            <div>
                                <label class="block text-xs">Price</label>
                                <input type="number" name="lines[][price]" value="0" step="0.01" class="mt-1 block w-24 border-gray-300 rounded-md text-xs">
                            </div>

                            <div>
                                <label class="block text-xs">Cost Price</label>
                                <input type="number" name="lines[][cost_price]" value="0" step="0.01" class="mt-1 block w-24 border-gray-300 rounded-md text-xs">
                            </div>

                            <button type="button" class="text-red-600 text-xs remove-line">Remove</button>
                        </div>
                    </template>

                    @foreach($proposal->lines as $line)
                        <div class="flex gap-2 mb-2 items-end">
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
                                    <option value="{{ $line->supplier_id }}" selected>{{ $line->supplier->name }}</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs">Quantity</label>
                                <input type="number" name="lines[][quantity]" value="{{ $line->quantity }}" class="mt-1 block w-20 border-gray-300 rounded-md text-xs">
                            </div>

                            <div>
                                <label class="block text-xs">Price</label>
                                <input type="number" name="lines[][price]" value="{{ $line->price }}" step="0.01" class="mt-1 block w-24 border-gray-300 rounded-md text-xs">
                            </div>

                            <div>
                                <label class="block text-xs">Cost Price</label>
                                <input type="number" name="lines[][cost_price]" value="{{ $line->cost_price }}" step="0.01" class="mt-1 block w-24 border-gray-300 rounded-md text-xs">
                            </div>

                            <button type="button" class="text-red-600 text-xs remove-line">Remove</button>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="add-line" class="mt-2 mb-4 px-3 py-1 bg-gray-200 text-xs rounded">Add Line</button>

                <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded text-xs hover:bg-blue-700">Update Proposal</button>
            </form>
        </div>
    </div>

    <script>
        const template = document.getElementById('line-template').content;
        const linesContainer = document.getElementById('lines');
        const addLineBtn = document.getElementById('add-line');

        addLineBtn.addEventListener('click', () => {
            const clone = document.importNode(template, true);
            clone.querySelector('.remove-line').addEventListener('click', e => {
                e.target.closest('div').remove();
            });
            linesContainer.appendChild(clone);
        });

        document.querySelectorAll('.remove-line').forEach(btn => {
            btn.addEventListener('click', e => e.target.closest('div').remove());
        });
    </script>
</x-app-layout>
