<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Encomenda {{ $order->number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: left; }
        th { background-color: #f0f0f0; }
        h1, h2 { margin: 0; padding: 0; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h1>Encomenda</h1>
    <h2>Número: {{ $order->number }}</h2>
    <p>Data: {{ $order->order_date }}</p>
    <p>Validade: {{ $order->valid_until }}</p>
    <p>Cliente: {{ $order->client->name }}</p>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Fornecedor</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Preço Custo</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->lines as $line)
                <tr>
                    <td>{{ $line->item->name }}</td>
                    <td>{{ $line->supplier->name ?? '—' }}</td>
                    <td>{{ $line->quantity }}</td>
                    <td>{{ number_format($line->price, 2) }} €</td>
                    <td>{{ number_format($line->cost_price, 2) }} €</td>
                    <td>{{ number_format($line->quantity * $line->price, 2) }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total: {{ number_format($order->total, 2) }} €</h3>
</body>
</html>
