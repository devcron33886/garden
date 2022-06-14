<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order placed</title>

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

        @media print {
            .no-print {
                display: none;
            }
        }

    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <br>
            <br>
            <a href="{{ route('home') }}" class="no-print">
                <div>
                    Back to Home
                </div>
                <img src="{{ asset('img/GARDEN_LOGO.png') }}" alt="" style="max-height: 100px">
            </a>


            <buton class="btn btn-primary pull-right btn-sm no-print"
                   onclick="window.print();">
                <i class="glyphicon glyphicon-print"></i>
                Print order
            </buton>
            <div class="clearfix"></div>

            <h4>Order placed</h4>
            <div id="printOrder">
                <table class="table billing-history">
                    <tbody>
                    <tr>
                        <td>
                            <span>
                                <b>Oder No</b>
                            </span>
                        </td>
                        <td> : {{ $order->order_no }}</td>
                    </tr>
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
                            <b>Delivery address</b>
                            </span>
                        </td>
                        <td> : {{ $order->shipping_address}}</td>
                    </tr>
                    </tbody>
                </table>

                <h4>Products ordered</h4>
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
                            Sub Total:
                        </th>
                        <th>
                            {{ $order->orderItems()->sum('sub_total') }} Rwf
                        </th>
                    </tr>
                    <tr>
                        <th colspan="3">
                            Shipping:
                        </th>
                        <th>
                            {{ number_format($order->shipping_amount) }} Rwf
                        </th>
                    </tr>
                    <tr>
                        <th colspan="3">
                            Total:
                        </th>
                        <th>
                            {{ number_format($order->getTotalAmountToPay()) }} Rwf
                        </th>
                    </tr>
                    <tr>
                        <th colspan="3">
                            <strong class="text-success">Total amount to Pay:</strong>
                        </th>
                        <th>
                            <strong class="text-success">
                                {{ number_format($order->getTotalAmountToPay()) }} Rwf
                            </strong>
                        </th>
                    </tr>
                    </tfoot>
                </table>
                <div>
                    <p>
                        <strong>Note:</strong>
                        <span> {{ $order->notes }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>


</body>
</html>
