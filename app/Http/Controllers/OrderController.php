<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Entity;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Display list of orders.
     */
    public function index()
    {
        $orders = Order::with('client')
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('orders.index', compact('orders'));
    }

    /**
     * Create order form.
     */
    public function create()
    {
        $clients = Entity::whereHas('types', fn($q) =>
            $q->where('name', 'client')
        )->get();

        $suppliers = Entity::whereHas('types', fn($q) =>
            $q->where('name', 'supplier')
        )->get();

        $items = Item::orderBy('reference')->get();

        return view('orders.create', compact('clients', 'suppliers', 'items'));
    }

    /**
     * Store new order.
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $order = Order::create([
                'number'      => $request->number,
                'order_date'  => $request->order_date,
                'client_id'   => $request->client_id,
                'valid_until' => $request->valid_until,
                'status'      => $request->status,
                'total'       => 0,
            ]);

            $total = 0;

            foreach ($request->lines as $line) {

                $lineTotal = $line['quantity'] * $line['price'];
                $total += $lineTotal;

                OrderLine::create([
                    'order_id'    => $order->id,
                    'item_id'     => $line['item_id'],
                    'supplier_id' => $line['supplier_id'] ?? null,
                    'quantity'    => $line['quantity'],
                    'price'       => $line['price'],
                    'cost_price'  => $line['cost_price'],
                ]);
            }

            $order->update(['total' => $total]);
        });

        return redirect()->route('orders.index')
            ->with('success', 'Order created successfully.');
    }

    /**
     * Edit order form.
     */
    public function edit(Order $order)
    {
        $order->load('lines');

        $clients = Entity::whereHas('types', fn($q) =>
            $q->where('name', 'client')
        )->get();

        $suppliers = Entity::whereHas('types', fn($q) =>
            $q->where('name', 'supplier')
        )->get();

        $items = Item::orderBy('reference')->get();

        return view('orders.edit', compact('order', 'clients', 'suppliers', 'items'));
    }

    /**
     * Update order.
     */
    public function update(Request $request, Order $order)
    {
        DB::transaction(function () use ($request, $order) {

            $order->update([
                'number'      => $request->number,
                'order_date'  => $request->order_date,
                'client_id'   => $request->client_id,
                'valid_until' => $request->valid_until,
                'status'      => $request->status,
            ]);

            // Delete old lines
            $order->lines()->delete();

            $total = 0;

            foreach ($request->lines as $line) {
                $lineTotal = $line['quantity'] * $line['price'];
                $total += $lineTotal;

                OrderLine::create([
                    'order_id'    => $order->id,
                    'item_id'     => $line['item_id'],
                    'supplier_id' => $line['supplier_id'] ?? null,
                    'quantity'    => $line['quantity'],
                    'price'       => $line['price'],
                    'cost_price'  => $line['cost_price'],
                ]);
            }

            $order->update(['total' => $total]);
        });

        return redirect()->route('orders.index')
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Delete order.
     */
    public function destroy(Order $order)
    {
        $order->lines()->delete();
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    /**
     * Generate PDF.
     */
    public function pdf(Order $order)
{
    $order->load('client', 'lines.item', 'lines.supplier');

    $pdf = Pdf::loadView('orders.pdf', [
        'order' => $order
    ]);

    $filename = 'Order_' . $order->number . '.pdf';
    return $pdf->stream($filename); 
    // return $pdf->download($filename); // força download
}

    /**
     * Convert order into supplier orders.
     */
    public function convertToSupplierOrders(Order $order)
    {
        $order->load('lines.item', 'lines.supplier');

        // Group lines by supplier
        $groups = $order->lines->groupBy('supplier_id');

        foreach ($groups as $supplierId => $lines) {

            $supplierOrder = Order::create([
                'number'      => 'F-' . now()->timestamp,
                'order_date'  => now()->toDateString(),
                'client_id'   => $supplierId,
                'status'      => 'closed',
                'total'       => 0,
            ]);

            $total = 0;

            foreach ($lines as $line) {

                $lineTotal = $line->quantity * $line->cost_price;
                $total += $lineTotal;

                OrderLine::create([
                    'order_id'    => $supplierOrder->id,
                    'item_id'     => $line->item_id,
                    'supplier_id' => $supplierId,
                    'quantity'    => $line->quantity,
                    'price'       => $line->cost_price,
                    'cost_price'  => $line->cost_price,
                ]);
            }

            $supplierOrder->update(['total' => $total]);
        }

        return redirect()->route('orders.index')
            ->with('success', 'Supplier Orders generated successfully!');
    }
}
