<div class="section">
    <div class="container">
        <div class="row">
            <section class="cart-items col-md-12">
                @if(count($errors)>0)
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <strong><i class="fa fa-warning"></i> Problem! </strong>
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    </div>
                @endif

                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="color-primary">
                            <i class="fa fa-shopping-bag"></i> Shopping cart
                        </h3>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-heading bg-white">
                                <h4 class="panel-title">
                                    Items in your shopping cart
                                </h4>
                            </div>
                            <div class="panel-body p-0">
                                @if(count($cart))
                                    <div class="table-responsive">
                                        <table class="table table-hover table-condensed ">
                                            <thead>
                                            <tr class="">
                                                <th class="hidden-xs">Image</th>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($cart as $cartItem)
                                                <livewire:cart-item :product="$cartItem->associatedModel"
                                                                    :cart-item="$cartItem"
                                                                    :key="$cartItem->id"/>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th colspan="6">
                                                    <button type="button" class="btn btn-default pull-right"
                                                            wire:click="removeAll">
                                                        <i class="fa fa-remove"></i>
                                                        Remove all items
                                                    </button>
                                                </th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-info m-2 flat text-center">
                                        <h5>
                                            <i class="fa fa-warning"></i> You have no items in the shopping basket
                                        </h5>
                                    </div>
                                @endif
                            </div>

                        </div>

                    </div>
                    <div class="col-md-3">
                        @if(count($cart))
                            <ul class="list-group">

                                <li class="list-group-item">
                                    Sub total
                                    <span class="badge">
                                        {{ number_format(Cart::getSubTotal()) }} RWF
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    Shipping amount
                                    <span class="pull-right" style=" background: white">
                                        {{ number_format($defaultSetting->shipping_amount) }} RWF
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    Total
                                    <span class="pull-right" style=" background: white">
                                        {{ number_format(Cart::getSubTotal()+$defaultSetting->shipping_amount) }} RWF
                                    </span>
                                </li>

                                <li class="list-group-item">
                                    <a href="{{ route('cart.get.checkout') }}"
                                       class="btn btn-success btn-block center-block">
                                        <i class="fa fa-shopping-bag"></i>
                                        Check out
                                    </a>
                                    <span class="clearfix"></span>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>

            </section>

        </div>
    </div>
</div>
