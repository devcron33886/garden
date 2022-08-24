<div>
    <div class="header-ctn" style="float: left">
        <!-- Cart -->
        <div>
            <a href="{{ route('cart.shoppingCart') }}">
                <i class="fa fa-shopping-basket"></i>
                <span>My Basket</span>
                <div class="qty">
                    {{ $count}}
                </div>
            </a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
