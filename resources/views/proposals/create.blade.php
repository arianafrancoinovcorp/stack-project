<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">Create Business Proposal</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Fill in the business proposal details</p>
                </div>
                <a href="{{ route('proposals.index') }}"
                    class="inline-flex items-center px-3 py-1.5 bg-gray-200 text-gray-800 text-xs font-medium rounded hover:bg-gray-300 transition-colors">
                    Back
                </a>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border-l-2 border-red-500 text-red-700 text-xs rounded-r">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                <form action="{{ route('proposals.store') }}" method="POST">
                    @csrf

                    <!-- Proposal Info -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <!-- Number -->
                        <div>
                            <label for="number" class="block text-xs font-medium text-gray-700">Number</label>
                            <input type="text" name="number" id="number" value="{{ old('number') }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <!-- Proposal Date -->
                        <div>
                            <label for="proposal_date" class="block text-xs font-medium text-gray-700">Proposal Date</label>
                            <input type="date" name="proposal_date" id="proposal_date"
                                value="{{ old('proposal_date', now()->format('Y-m-d')) }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <!-- Client -->
                        <div class="sm:col-span-2">
                            <label for="client_id" class="block text-xs font-medium text-gray-700">Client</label>
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

                        <!-- Valid Until -->
                        <div>
                            <label for="valid_until" class="block text-xs font-medium text-gray-700">Valid Until</label>
                            <input type="date" name="valid_until" id="valid_until"
                                value="{{ old('valid_until', now()->addDays(30)->format('Y-m-d')) }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-xs font-medium text-gray-700">Status</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>
                    </div>

                    <!-- Proposal Lines Section -->
                    <div class="mt-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-sm font-medium text-gray-900">Proposal Lines</h3>
                            <button type="button" id="add-line"
                                class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 transition-colors">
                                + Add Line
                            </button>
                        </div>

                        <div id="lines" class="space-y-3">
                            <!-- As linhas serão adicionadas aqui dinamicamente -->
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                            class="px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded shadow hover:bg-blue-700 transition-colors">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const linesContainer = document.getElementById('lines');
        const addLineBtn = document.getElementById('add-line');
        let lineIndex = 0;

        const items = @json($items);
        const suppliers = @json($suppliers);

        function createLine() {
            const lineDiv = document.createElement('div');
            lineDiv.className = 'bg-gray-50 p-4 rounded border border-gray-200';
            lineDiv.innerHTML = `
                <div class="grid grid-cols-1 sm:grid-cols-6 gap-3">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-gray-700">Item</label>
                        <select name="lines[${lineIndex}][item_id]" class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Select Item</option>
                            ${items.map(item => `<option value="${item.id}">${item.reference} - ${item.name}</option>`).join('')}
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-gray-700">Supplier</label>
                        <select name="lines[${lineIndex}][supplier_id]" class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Select Supplier</option>
                            ${suppliers.map(supplier => `<option value="${supplier.id}">${supplier.name}</option>`).join('')}
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700">Quantity</label>
                        <input type="number" name="lines[${lineIndex}][quantity]" value="1" min="1" class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700">Price</label>
                        <input type="number" name="lines[${lineIndex}][price]" value="0" step="0.01" class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-gray-700">Cost Price</label>
                        <input type="number" name="lines[${lineIndex}][cost_price]" value="0" step="0.01" class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="sm:col-span-6 flex justify-end mt-2">
                        <button type="button" class="remove-line inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition-colors">
                            Remove
                        </button>
                    </div>
                </div>
            `;
            lineDiv.querySelector('.remove-line').addEventListener('click', () => lineDiv.remove());
            linesContainer.appendChild(lineDiv);
            lineIndex++;
        }

        addLineBtn.addEventListener('click', createLine);
        createLine(); // Linha inicial
    </script>
</x-app-layout>
