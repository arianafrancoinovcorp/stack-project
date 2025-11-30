<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">Edit Item</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Update item details</p>
                </div>
                <a href="{{ route('items.index') }}"
                   class="inline-flex items-center px-3 py-1.5 bg-gray-200 text-gray-800 text-xs font-medium rounded hover:bg-gray-300 transition-colors">
                    Back
                </a>
            </div>

            <!-- Validation Errors -->
            @if($errors->any())
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
                <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <!-- Reference -->
                        <div>
                            <label for="reference" class="block text-xs font-medium text-gray-700">Reference</label>
                            <input type="text" name="reference" id="reference" value="{{ old('reference', $item->reference) }}"
                                   class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-xs font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $item->name) }}"
                                   class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Description -->
                        <div class="sm:col-span-2">
                            <label for="description" class="block text-xs font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3"
                                      class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $item->description) }}</textarea>
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-xs font-medium text-gray-700">Price (€)</label>
                            <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $item->price) }}"
                                   class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- VAT -->
                        <div>
                            <label for="vat_id" class="block text-xs font-medium text-gray-700">VAT</label>
                            <select name="vat_id" id="vat_id"
                                    class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select VAT</option>
                                @foreach($vats as $vat)
                                    <option value="{{ $vat->id }}" {{ old('vat_id', $item->vat_id) == $vat->id ? 'selected' : '' }}>
                                        {{ $vat->name }} ({{ $vat->percentage }}%)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Photo -->
                        <div class="sm:col-span-2">
                            <label for="photo" class="block text-xs font-medium text-gray-700">Photo</label>
                            <input type="file" name="photo" id="photo" class="mt-1 block w-full text-sm text-gray-700">
                            @if($item->photo)
                                <img src="{{ asset('storage/' . $item->photo) }}" class="h-16 w-16 object-cover rounded mt-2" />
                            @endif
                        </div>

                        <!-- Notes -->
                        <div class="sm:col-span-2">
                            <label for="notes" class="block text-xs font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                      class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $item->notes) }}</textarea>
                        </div>

                        <!-- Status -->
                        <div class="sm:col-span-2">
                            <label for="status" class="block text-xs font-medium text-gray-700">Status</label>
                            <select name="status" id="status"
                                    class="mt-1 block w-full rounded border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="active" {{ old('status', $item->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $item->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                                class="px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded shadow hover:bg-blue-700 transition-colors">
                            Update
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
