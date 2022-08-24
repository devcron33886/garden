@component('mail::message')
# Order status updated

<br>
@if($order->status==\App\Order::PENDING)
    <p>
        <strong>{{ $user->name }}</strong> : updated your order status
    </p>
@elseif($order->status==\App\Order::PROCESSING)
    <p>
        <strong>{{ $user->name }}</strong> is processing your order
    </p>
@elseif($order->status==\App\Order::ON_WAY)
    <p>
        Order is on its way.
        <strong>{{ ucfirst($user->name) }}</strong> is on his way to bring your purchased products.
    </p>
@elseif($order->status==\App\Order::DELIVERED)
    <p>
        Order delivered,
        <strong>{{ $user->name }}</strong> delivered your order.
    </p>
@elseif($order->status==\App\Order::CANCELLED)
    <p>
         Order cancelled.
        <strong>{{ $user->name }}</strong> cancels your order.
    </p>
@elseif($order->status==\App\Order::PAID)
    <p>
         Payment have been processed.Thank you!
    </p>
@endif
<span>{{ $order->updated_at->format('j M Y h:i a') }}</span>
<br>

@component('mail::table')
    <table class="table">
        <tbody>
        <tr><td><span><b>Oder status</b></span></td>
            <td> :
                @if($order->status==\App\Order::PENDING)
                    <span class="label label-info rounded-pill">{{ $order->status }}</span>
                @elseif($order->status==\App\Order::PROCESSING)
                    <span class="label label-info rounded-pill">{{ $order->status }}</span>
                @elseif($order->status==\App\Order::ON_WAY)
                    <span class="label label-primary rounded-pill">{{ $order->status }}</span>
                @elseif($order->status==\App\Order::DELIVERED)
                    <span class="label label-success rounded-pill">{{ $order->status }}</span>
                @elseif($order->status==\App\Order::PAID)
                    <span class="label bg-green rounded-pill">{{ $order->status }}</span>
                @elseif($order->status==\App\Order::CANCELLED)
                    <span class="label label-danger rounded-pill">{{ $order->status }}</span>
                @endif
            </td>
        </tr>
        <tr><td><span><b>Oder No</b></span></td><td> : {{ $order->order_no }}</td></tr>
        <tr><td><span><b>Oder date</b></span></td><td> : {{ $order->created_at->format('j M Y h:i a') }}</td></tr>
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
@endcomponent

<br>
<br>

@component('mail::button', ['url' => url('/'),'color' => 'success'])
    Place your order again
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
