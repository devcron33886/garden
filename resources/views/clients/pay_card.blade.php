@extends('layouts.app')
@section('title', ' My-orders')
@section('content')

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Order Placed</h4>
                    <div class="alert alert-success rounded-sm" role="alert">
                        <h4 class="alert-heading">
                            <span class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                     fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                      clip-rule="evenodd"/>
                            </svg>
                            </span>
                            Thank you!
                        </h4>
                        <p>
                            Thank you for placing your order , please wait the dialog to pay.
                        </p>
                    </div>
                </div>


            </div>
        </div>
        <div class="container">
            <div class="row">

                <div class="col-md-6">
                    <h5 class="font-weight-light text-uppercase">
                        Shipping address
                    </h5>
                    <p>
                        Client Name : <strong>{{ $order->clientName }}</strong>
                    </p>
                    <p>
                        Email address : <strong>{{ $order->email ?? 'N/A' }}</strong>
                    </p>
                    <p>
                        Address : <strong>{{ $order->shipping_address ?? 'N/A' }}</strong>
                    </p>
                    <p>
                        Phone : <strong>{{ $order->clientPhone }}</strong>
                    </p>

                    <p>
                        <strong>Notes:</strong>
                        <span>{{ $order->notes ?? 'N/A' }}</span>
                    </p>
                </div>
                <div class="col-md-6">
                    <h3 class="text-success panel-title">
                        Pay Now To Complete your Order
                    </h3>
                    <br>
                    <h5 class="font-weight-light text-uppercase">
                        Products Ordered
                    </h5>
                    <ul class="list-group">
                        @foreach ($order->orderItems as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $item->product->name }} ({{ $item->qty }})
                                <span class="badge badge-success badge-pill">
                                    {{ number_format($item->total) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>

                    <a href="" class="btn btn-success btn-lg rounded-sm">
                        <i class="fa fa-credit-card"></i>
                        Pay <small>{{ number_format($order->getTotalAmountToPay()) }}</small> Now
                    </a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
@endsection

@section('scripts')
    <script src="https://checkout.flutterwave.com/v3.js"></script>

    <script>
        function makePayment() {
            FlutterwaveCheckout({
                public_key: "{{ config('app.FW_PUBLIC') }}",
                tx_ref: "{{ time() . rand(10 * 45, 100 * 98) }}",
                amount: {{ $order->getTotalAmountToPay() }},
                currency: "RWF",
                country: "RWF",
                payment_options: "mobilemoneyrwanda",
                customer: {
                    email: "{{ $order->email }}",
                    phone_number: "{{ $order->clientPhone }}",
                    name: "{{ $order->clientName }}"
                },
                callback: function (data) {
                    if (data.transaction_id) {
                        data['_token'] = "{{ csrf_token() }}";
                        $.ajax({
                            url: "{{ route('payment.success', ['orderId' => encryptId($order->id)]) }}",
                            data: data,
                            method: 'POST',
                            type: 'json',
                            success: function (response) {
                                window.location = response.url;
                            }
                        });
                    } else {
                        alert("Transaction failed . try again")
                    }

                },
                onclose: function () {
                    // close modal
                },
                customizations: {
                    title: "{{ config('app.name') }}",
                    description: "Pay to complete your order",
                    logo: "{{ asset('img/GARDEN_LOGO.png') }}",
                },
            });
        }

        window.addEventListener('DOMContentLoaded', (event) => {
            makePayment();
        });

    </script>
@stop
