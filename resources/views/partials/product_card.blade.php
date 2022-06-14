<div class="product rounded">
    <div class="product-img rounded">
        <a href="{{ route('products.details-view',$item->id) }}">
            <div style="height: 232px;overflow: hidden">
                <img style="width: 100%"
                     class="lozad rounded" data-src="{{ asset('uploads/products/'.$item->image) }}"
                     alt="" src="">
            </div>
        </a>

        <div class="product-label">
            @if($item->discount>0)
                <span class="sale rounded">-{{ $item->discount }}%</span>
            @endif
            @if(isset($label))
                <span class="new rounded-pill">{{$label}}</span>
            @endif
        </div>
    </div>
    <div class="product-body rounded">
        <p class="product-category">{{ $item->category->name }}</p>
        <h3 class="product-name" style="height: 20px;">
            <a href="javascript:void(0);">
                {{ str_limit($item->name,25) }}
            </a>
        </h3>
        <h4 class="product-price">
            RF {{ number_format($item->getRealPrice()) }}
            @if($item->discount>0)
                <del class="product-old-price">
                    RF {{ number_format($item->price) }}
                </del>
            @endif
        </h4>
        <h5>
            {{ $item->measure }}
        </h5>
        <div class="bg-white rounded m-2">
            @if($item->status==='Available')
                <a href="{{ route('cart.addToCart',['id'=>$item->id]) }}"
                   class="btn btn-sm text-uppercase btn-danger rounded center-block">
                    <i class="fa fa-shopping-bag"></i>
                    add to basket
                </a>
            @else
                <a href="javascript:void(0);"
                   class="btn btn-sm text-uppercase btn-danger rounded center-block" disabled="">
                    <i class="fa fa-ban"></i>
                    Out of stock
                </a>
            @endif
        </div>
    </div>

</div>
