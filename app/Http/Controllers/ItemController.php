<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Vat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $items = Item::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%")
                                      ->orWhere('reference', 'like', "%{$search}%"))
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('items.index', compact('items', 'search', 'status'));
    }

    public function create()
    {
        $vats = Vat::all();
        return view('items.create', compact('vats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'required|unique:items,reference',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'vat_id' => 'required|exists:vats,id',
            'photo' => 'nullable|image|max:2048',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('items', 'public');
        }

        Item::create($validated);

        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    public function edit(Item $item)
    {
        $vats = Vat::all();
        return view('items.edit', compact('item', 'vats'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'reference' => 'required|unique:items,reference,' . $item->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'vat_id' => 'required|exists:vats,id',
            'photo' => 'nullable|image|max:2048',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        if ($request->hasFile('photo')) {
            if ($item->photo) Storage::disk('public')->delete($item->photo);
            $validated['photo'] = $request->file('photo')->store('items', 'public');
        }

        $item->update($validated);

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item)
    {
        if ($item->photo) Storage::disk('public')->delete($item->photo);
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }
}
