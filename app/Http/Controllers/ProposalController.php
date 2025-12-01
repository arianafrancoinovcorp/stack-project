<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\ProposalLine;
use App\Models\Entity;
use App\Models\Item;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $proposals = Proposal::with('client')
            ->when($search, fn($q) => $q->where('number', 'like', "%{$search}%")
                                         ->orWhereHas('client', fn($q2) => $q2->where('name', 'like', "%{$search}%")))
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('proposals.index', compact('proposals', 'search', 'status'));
    }

    public function create()
    {
        $clients = Entity::whereHas('types', function ($query) {
            $query->where('name', 'client'); 
        })->get();
        $items = Item::all();

        $suppliers = Entity::whereHas('types', function ($query) {
            $query->where('name', 'supplier');
        })->get();

        return view('proposals.create', compact('clients', 'items', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|unique:proposals,number',
            'proposal_date' => 'required|date',
            'client_id' => 'required|exists:entities,id',
            'valid_until' => 'required|date|after_or_equal:proposal_date',
            'status' => 'required|in:draft,closed',
            'lines' => 'required|array|min:1',
            'lines.*.item_id' => 'required|exists:items,id',
            'lines.*.supplier_id' => 'required|exists:entities,id',
            'lines.*.quantity' => 'required|integer|min:1',
            'lines.*.price' => 'required|numeric|min:0',
            'lines.*.cost_price' => 'nullable|numeric|min:0',
        ]);

        $proposal = Proposal::create([
            'number' => $validated['number'],
            'proposal_date' => $validated['proposal_date'],
            'client_id' => $validated['client_id'],
            'valid_until' => $validated['valid_until'], // <- adicionado
            'status' => $validated['status'],
            'total' => 0,
        ]);
        

        $total = 0;

        foreach ($validated['lines'] as $line) {
            $subtotal = $line['price'] * $line['quantity'];
            $total += $subtotal;

            $proposal->lines()->create([
                'item_id' => $line['item_id'],
                'supplier_id' => $line['supplier_id'],
                'quantity' => $line['quantity'],
                'price' => $line['price'],
                'cost_price' => $line['cost_price'] ?? 0,
                'subtotal' => $subtotal,
            ]);
        }

        $proposal->total = $total;
        $proposal->save();

        return redirect()->route('proposals.index')->with('success', 'Proposal created successfully.');
    }

    public function edit(Proposal $proposal)
    {
        $proposal->load('lines.item', 'lines.supplier', 'client');

        $clients = Entity::where('type', 'client')->get();
        $items = Item::all();

        return view('proposals.edit', compact('proposal', 'clients', 'items'));
    }

    public function update(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'number' => 'required|unique:proposals,number,' . $proposal->id,
            'proposal_date' => 'required|date',
            'client_id' => 'required|exists:entities,id',
            'valid_until' => 'required|date|after_or_equal:proposal_date',
            'status' => 'required|in:draft,closed',
            'lines' => 'required|array|min:1',
            'lines.*.item_id' => 'required|exists:items,id',
            'lines.*.supplier_id' => 'required|exists:entities,id',
            'lines.*.quantity' => 'required|integer|min:1',
            'lines.*.price' => 'required|numeric|min:0',
            'lines.*.cost_price' => 'nullable|numeric|min:0',
        ]);

        $proposal->update([
            'number' => $validated['number'],
            'proposal_date' => $validated['proposal_date'],
            'client_id' => $validated['client_id'],
            'valid_until' => $validated['valid_until'],
            'status' => $validated['status'],
        ]);

        // Apaga linhas antigas e cria novas
        $proposal->lines()->delete();

        $total = 0;
        foreach ($validated['lines'] as $line) {
            $subtotal = $line['price'] * $line['quantity'];
            $total += $subtotal;

            $proposal->lines()->create([
                'item_id' => $line['item_id'],
                'supplier_id' => $line['supplier_id'],
                'quantity' => $line['quantity'],
                'price' => $line['price'],
                'cost_price' => $line['cost_price'] ?? 0,
                'subtotal' => $subtotal,
            ]);
        }

        $proposal->total = $total;
        $proposal->save();

        return redirect()->route('proposals.index')->with('success', 'Proposal updated successfully.');
    }

    public function destroy(Proposal $proposal)
    {
        $proposal->delete();
        return redirect()->route('proposals.index')->with('success', 'Proposal deleted successfully.');
    }
}
