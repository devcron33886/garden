<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New order</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .billing-history tbody > tr > td {
            padding: 10px;
        }

    </style>
</head>
<body>
<h4>New order</h4>
<hr>
<div id="printOrder">
    <table class="table billing-history">
        <thead class="sr-only">
        <tr>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
            <span>
                <b>Oder date</b>
            </span>
            </td>
            <td> : {{ date('j M Y h:i a', strtotime($order->created_at)) }}</td>
        </tr>
        <tr>
            <td>
            <span>
                <b>Client</b>
            </span>
            </td>
            <td> : {{ $order->user===null ? $order->clientName:$order->user->name }}</td>
        </tr>
        <tr>
            <td>
            <span>
            <b>Client phone</b>
            </span>
            </td>
            <td> : {{ \App\MyFunc::format_phone_us($order->clientPhone) }}</td>
        </tr>
        <tr>
            <td>
            <span>
            <b>Email address</b>
            </span>
            </td>
            <td> : {{$order->email }}</td>
        </tr>
        <tr>
            <td>
            <span>
            <b>Shipping address</b>
            </span>
            </td>
            <td> : {{ $order->shipping_address}}</td>
        </tr>
        </tbody>
    </table>

    <h4>Products ordered</h4>
    <hr>
    <table class="table table-bordered table-responsive table-striped">
        <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->orderItems as $orderItem)
            <tr>
                <td>{{ $orderItem->product->name }}</td>
                <td>{{ number_format($orderItem->price) }}</td>
                <td>{{ $orderItem->qty }}</td>
                <td>{{ number_format($orderItem->sub_total) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="3">
                Sub Total
            </th>
            <th>
                : {{ $order->orderItems()->sum('sub_total') }} Rwf
            </th>
        </tr>
        <tr>
            <th colspan="3">
                Shipping
            </th>
            <th>
                : {{ number_format($order->shipping_amount) }} Rwf
            </th>
        </tr>
        <tr>
            <th colspan="3">
                Total
            </th>
            <th>
                : {{ number_format($order->orderItems()->sum('sub_total')+$order->shipping_amount) }} Rwf
            </th>
        </tr>
        </tfoot>
    </table>
    <hr>
    <p>
        <strong>Note:</strong>
        <p>{{ $order->notes }}</p>
    </p>
    <hr>

    <table class="table billing-history">
        <thead class="sr-only">
        <tr>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td>
            <span>
                <b>Total amount to Pay</b>
            </span>
            </td>
            <td> : <b>{{ number_format($order->orderItems->sum('sub_total')+$order->shipping_amount) }} Rwf</b></td>
        </tr>
        </tbody>
    </table>

</div>


</body>
</html>