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
            <input type="number" name="lines[][price]" value="0"
                   step="0.01" class="mt-1 block w-24 border-gray-300 rounded-md text-xs">
        </div>

        <div>
            <label class="block text-xs">Cost</label>
            <input type="number" name="lines[][cost_price]" value="0"
                   step="0.01" class="mt-1 block w-24 border-gray-300 rounded-md text-xs">
        </div>

        <button type="button" class="text-red-600 text-xs remove-line">Remove</button>
    </div>
</template>
