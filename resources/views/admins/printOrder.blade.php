<!doctype html>
<html lang="en">

<head>
    <title>Print order</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro');

        html, body {
            font-family: 'Source Sans Pro', sans-serif;
            /*font-size: 15px !important;*/
        }

        .billing-history tbody > tr > td {
            padding: 10px;
        }

        @media print {
            .no-print, .no-print * {
                display: none !important;
            }
        }

        .billing-history tbody > tr > td {
            padding: 25px 10px 25px 0;
            vertical-align: middle;
            border-top: none;
            border-bottom: 1px solid #e8e8e8;
        }

        .billing-custom tbody > tr > td {
            padding: 25px 10px 25px 0;
            vertical-align: middle;
            border-top: none;
            border-bottom: none;
        }

        .flat {
            border-radius: 0;
        }
    </style>

</head>
<body>
<br>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary btn-sm pull-right no-print"
                    onclick="window.print()">
                <i class="glyphicon glyphicon-print"></i>
                Print order
            </button>
        </div>
    </div>
    <br>
    <div class="row">

        <div class="panel panel-default flat">
            <div class="panel-heading flat">
                <img src="{{ asset('img/GARDEN_LOGO.png') }}" alt="Garden Of Eden Produce"
                     style="width: 50px;float: left;vertical-align: middle">
                <h4 class="pull-right">Garden of eden produce</h4>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body flat">
                <div id="printOrder" class="">
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
                            <td> : {{ date('j M Y , h:i a', strtotime($order->created_at)) }}</td>
                        </tr>
                        <tr>
                            <td>
                                <span>
                                    <b>Client name</b>
                                </span>
                            </td>
                            <td> : {{ $order->clientName }}</td>
                        </tr>
                        <tr>
                            <td>
                                <span>
                                    <b>Shipping address</b>
                                </span>
                            </td>
                            <td> : {{ $order->shipping_address }}</td>
                        </tr>
                        <tr>
                            <td>
                                <span>
                                    <b>Email address</b>
                                </span>
                            </td>
                            <td> : {{ $order->email }}</td>
                        </tr>
                        <tr>
                            <td>
                                <span><b>Client phone</b></span>
                            </td>
                            <td> : {{  \App\MyFunc::format_phone_us($order->clientPhone)}}</td>
                        </tr>
                        </tbody>
                    </table>

                    <h4 class="text-info">Products ordered</h4>
                    <table class="table table-responsive table-striped table-bordered">
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
                            <td colspan="3">
                                    <span>
                                        <b>Sub total:</b>
                                    </span>
                            </td>
                            <td>
                                <b>{{ number_format($order->orderItems->sum('sub_total')) }} Rwf</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                    <span>
                                        <b>Shipping amount to Pay:</b>
                                    </span>
                            </td>
                            <td>
                                <b>{{ number_format($order->shipping_amount) }} Rwf</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                    <span>
                                        <b>Grand total:</b>
                                    </span>
                            </td>
                            <td>
                                <b>{{ number_format($order->getTotalAmountToPay()) }} Rwf</b>
                            </td>
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
            <div class="panel-footer flat">
                <div>
                   <span>
                        Garden of eden produce
                   </span>
                    <span class="pull-right">
                        <small>Date:{{ date('j M Y') }}</small>
                    </span>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    //    window.print()
</script>
</body>
</html>
