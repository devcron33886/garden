@component('mail::message')
# Your order no {{ $order->order_no }} Has been placed.

We have received your order, we are going to process it asap.

@component('mail::button', ['url' => '','color' => 'success'])
Shop again
@endcomponent

Thank you for shopping with us,<br>
{{ config('app.name') }}
@endcomponent
