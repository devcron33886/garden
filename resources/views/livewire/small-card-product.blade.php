<div class="product-widget" wire:loading.class="loading">
    <div class="product-img">
        <img class="lozad rounded-sm shadow-sm thumbnail img-responsive"
             style="width: 60px;height: 70px;object-fit: cover"
             src="{{ asset($product->imageUrl) }}" alt="{{ $product->name }}">
    </div>
    <div class="product-body">
        <h6>
            <a href="{{ route('products.details-view',$product->id) }}">
                {{ ucfirst($product->name) }}
            </a>
        </h6>
        <h6>
            {{ number_format($product->price) }}
            <small>/{{ $product->measure }}</small>
        </h6>
        @if($added)
            <a href="{{ route('cart.removeItem',['id'=>$product->id]) }}"
               class="btn text-uppercase btn-outline-danger btn-xs rounded-sm">
                Remove
            </a>
        @else
            <a href="{{ route('cart.addToCart',['id'=>$product->id]) }}"
               class="btn text-uppercase btn-success btn-xs rounded-sm">
                Basket
            </a>
        @endif
    </div>
    <hr>
</div>
