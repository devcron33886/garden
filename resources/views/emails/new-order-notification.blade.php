@component('mail::message')
    # Order placed

    @component('mail::table')
        <table class="">
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
                    <td><span><b>Oder No</b></span></td>
                    <td> : {{ $order->order_no }}</td>
                </tr>
                <tr>
                    <td>
                        <span>
                            <b>Client</b>
                        </span>
                    </td>
                    <td> : {{ $order->user === null ? $order->clientName : $order->user->name }}</td>
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
                    <td> : {{ $order->email }}</td>
                </tr>
                <tr>
                    <td>
                        <span>
                            <b>Shipping address</b>
                        </span>
                    </td>
                    <td> : {{ $order->shipping_address }}</td>
                </tr>
            </tbody>
        </table>
    @endcomponent

    # Products ordered

    @component('mail::table')
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
                @foreach ($order->orderItems as $orderItem)
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
                        : {{ number_format($order->orderItems()->sum('sub_total')) }} Rwf
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
                        : {{ number_format($order->orderItems()->sum('sub_total') + $order->shipping_amount) }} Rwf
                    </th>
                </tr>
            </tfoot>
        </table>
    @endcomponent

    # Note:

    <p>{{ $order->notes }}</p>

    @component('mail::button', ['url' => url('/'), 'color' => 'success'])
        Shop Again
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
