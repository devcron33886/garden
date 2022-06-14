@extends('layouts.app')
@section('title',' My-orders')
@section('content')

    <br>
    <div class="section">
        <div class="container">
            <div class="row">
                <section class="col-md-12">
                    <div class="panel panel-default rounded-sm shadow-sm">
                        <div class="panel-heading bg-white">
                            <h3 class="text-success panel-title">
                                <i class="fa fa-check-square"></i>
                                Check out
                            </h3>
                        </div>
                        <div class="panel-body p-0 table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $total = 0; ?>
                                @foreach($cart as $cartItem)

                                    <tr>
                                        <td>
                                            <h5>{{ $cartItem->name }}</h5>
                                        </td>
                                        <td>
                                            <p>
                                                {{ number_format($cartItem->price) }}
                                                <small>Rwf</small>
                                            </p>
                                        </td>
                                        <td>
                                            <p>
                                                {{ $cartItem->quantity }}
                                            </p>
                                        </td>
                                        <td>
                                            <p>
                                                {{ number_format($cartItem->getPriceSum()) }}
                                                <small>Rwf / {{ $cartItem->associatedModel->measure }} </small>
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>
                                        Sub Total :
                                    </th>
                                    <th colspan="3" class="text-success">
                                        {{ number_format(Cart::getSubTotal()) }} Rwf
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        Shipping:
                                    </th>
                                    <th colspan="3" class="text-success">
                                        + {{ number_format($defaultSetting->shipping_amount) }} Rwf
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        Total:
                                    </th>
                                    <th colspan="3" class="text-success">
                                        <span class="label label-success">{{ number_format(Cart::getSubTotal()+$defaultSetting->shipping_amount) }} Rwf</span>
                                    </th>
                                </tr>
                                </tfoot>

                            </table>
                        </div>

                    </div>
                </section>
                <section class="col-md-12">
                    @if(Session::has('message'))
                        <div class="alert alert-success flat">
                            <p>
                                <i class="fa fa-check-circle"></i>
                                {{ Session::get('message') }}
                            </p>
                        </div>
                    @endif

                    <div class="panel panel-default rounded-sm shadow-sm">
                        <div class="panel-heading bg-white">
                            <h3 class="panel-title">
                                Delivery information
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form action="{{ route('cart.checkOut') }}" id="checkoutForm"
                                  class="" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group  {{ $errors->has('clientName')?'has-error':''}} ">
                                            <label for="clientName" class="control-label">Name</label>
                                            <input type="text" placeholder="Full name" required
                                                   value="{{Request::old('clientName')}}"
                                                   class="form-control rounded-sm" name="clientName"
                                                   id="clientName" maxlength="120">
                                            @if ($errors->has('clientName'))
                                                <span class="help-block">
                                                    {{ $errors->first('clientName') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group  {{ $errors->has('email')?'has-error':''}} ">
                                            <label for="client_email" class="control-label">Email</label>
                                            <div>
                                                <input type="email" placeholder="Email address"
                                                       value="{{Request::old('email')}}" required
                                                       class="form-control rounded-sm" name="email"
                                                       id="client_email" maxlength="120">
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                    {{ $errors->first('email') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group  {{ $errors->has('shipping_address')?'has-error':''}} ">
                                            <label for="shipping_address" class="control-label">Address</label>
                                            <input type="text" placeholder="Shipping address"
                                                   value="{{Request::old('shipping_address')}}" required
                                                   class="form-control rounded-sm" name="shipping_address"
                                                   id="shipping_address" maxlength="120">
                                            @if ($errors->has('shipping_address'))
                                                <span class="help-block">
                                                   {{ $errors->first('shipping_address') }}
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group  {{ $errors->has('phoneNumber')?'has-error':''}}">
                                            <label for="phoneNumber" class="control-label">Phone</label>
                                            <input type="text"
                                                   placeholder="Phone number"
                                                   value="{{Request::old('phoneNumber')}}" maxlength="13" required
                                                   class="form-control rounded-sm" name="phoneNumber" id="phoneNumber">
                                            @if ($errors->has('phoneNumber'))
                                                <span class="help-block">
                                                  {{ $errors->first('phoneNumber') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="notes" class="control-label d-block">Payment method</label>
                                        <div class="form-group">
                                            <label class="custom-input-container">
                                                Cash On delivery
                                                <input type="radio" name="payment_type" required value="Cash">
                                                <span class="checkmark"></span>
                                            </label>
                                          {{--  <label class="custom-input-container">
                                                Pay by mobile money
                                                <input type="radio" name="payment_type" required
                                                       value="{{ \App\Payment::CARD_MOBILE_MONEY }}">
                                                <span class="checkmark"></span>
                                            </label>--}}
                                            <label id="payment_type-error" class="error d-block"
                                                   for="payment_type"></label>
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group  {{ $errors->has('notes')?'has-error':''}}">
                                            <label for="notes" class="control-label">Note</label>
                                            <textarea rows="5" maxlength="2000"
                                                      style="resize: vertical"
                                                      placeholder="Write something extra here.. like notes. (Optional)"
                                                      class="form-control rounded-sm" name="notes"
                                                      id="notes">{{Request::old('notes')}}</textarea>
                                            @if ($errors->has('notes'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('notes') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-lg rounded-sm" id="btnSubmit">
                                        <i class="fa fa-check-circle"></i>
                                        Place Your Order
                                    </button>
                                </div>


                            </form>

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <br>
    <br>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>

    <script>
        $(function () {
            var $checkoutForm = $('#checkoutForm');
            $checkoutForm.validate({
                rules: {
                    payment_type: "required",
                },
                messages: {
                    payment_type: {
                        required: "Please choose payment method",
                        // minlength: jQuery.format("Enter at least {0} characters"),
                        // remote: jQuery.format("{0} is already in use")
                    }
                }
            });

        });
    </script>
@stop
