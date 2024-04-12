<!DOCTYPE html>
<html>
<head>
    <title>Invoice - {{ $invoice->customer_name }}</title>
</head>
<style>
    table {
        width: 100%;
    }
    table, th, td {
        border: 1px solid;
        border-collapse: collapse;
    }

    th, td {
        padding: 8px;
    }
</style>

<body>
    <table>
        <thead>
            <tr>
                <th colspan="2">Customer</th>
                <th colspan="5">{{ $invoice->customer_name }}</th>
            </tr>
            <tr>
                <th>No</th>
                <th>Category</th>
                <th>Fruit</th>
                <th>Unit</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Amount</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($invoice->fruits as $fruit)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $fruit->category->name }}</td>
                    <td>{{ $fruit->name }}</td>
                    <td>{{ $fruit->unit }}</td>
                    <td>{{ $fruit->price }}</td>
                    <td>{{ $fruit->pivot->quantity }}</td>
                    <td>{{ $fruit->pivot->amount }}</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot style="font-weight: bold;">
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total</td>
                <td>{{ $invoice->fruits->sum('pivot.amount') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>