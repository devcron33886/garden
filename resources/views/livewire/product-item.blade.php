<div class="row">
    <div class="col-sm-3 container-div">
        <a title="View full size"
           href="{{ route('products.details-view',$product->id) }}">
            <img src="{{ asset("uploads/products/" . $product->image) }}"
                 alt="" style="width: 100%"
                 class="lozad grow img-responsive">
        </a>
    </div>
    <div class="col-sm-9">
        <div class="caption">
            <h5 class="pull-right">
                                                            <span class="text-success" style="padding-right: 20px">
                                                                 {{ number_format($product->getRealPrice(),1) }}
                                                            </span>
                @if($product->discount>0)
                    <del class="product-old-price text-danger">
                        <span>{{ number_format($product->price) }}</span>
                    </del>
                @endif
                <small>Rwf / {{ $product->measure }}</small>
            </h5>
            <h4 class="product-name">
                <span>{{ $product->name }}</span>
            </h4>
            <p class="hidden-xs">
                @if($product->description!=='')
                    {{ str_limit($product->description,150) }}
                @else
                    <span class="label label-default">
                                                                    No description available
                                                                </span>
                @endif
            </p>
        </div>
        @if($product->discount>0)
            <span class="label label-success rounded-pill">{{  $product->getDiscountPercent()}} Rwf ,OFF</span> <br>
            <br>
        @endif
        <div class="ratings margin-left-sm">
            <div class="">{{ $product->qty }} in stock</div>
            <br>
            <div class="my-2">
                <a href="/getProduct?cat={{ $product->category->id }}">
                    {{ $product->category->name }}
                </a>
            </div>
            <div class="my-2">
                @if($product->status==='Available')
                    <form action="{{ route('cart.addToCart',['id'=>$product->id]) }}" class="form-inline">

                        @if($added)
                            <button wire:loading.attr="disabled" type="button" wire:click="remove"
                                    class="btn  btn-danger">
                                <i class="fa fa-times"></i>
                                Remove
                            </button>
                        @else
                            <div class="input-group">
                                <input min="0.5" size="10"
                                       value="1" type="text" wire:model="quantity"
                                       max="{{ $product->qty }}" name="qty"
                                       class="form-control flat"
                                       placeholder="Qty"
                                       id="qty{{$product->id}}">
                                <span class="input-group-btn">
                                    <button wire:loading.attr="disabled" type="button" wire:click="add"
                                            class="btn  btn-success flat" {{ $product->qty <=0 ? 'disabled':'' }}>
                                        <i class="fa fa-plus"></i>
                                        Add
                                    </button>
                          </span>
                            </div><!-- /input-group -->
                        @endif


                    </form>
                @else
                    <span class="label label-default rounded-pill"><i
                                class="fa fa-warning"></i> &nbsp; Out Of Stock</span>
                @endif
            </div>

            <div class="clearfix"></div>
        </div>

        <a href="{{ route('products.details-view',$product->id) }}"
           class="btn btn-danger btn-sm flat text-uppercase">
            More Detail
            <i class="fa fa-chevron-right"></i>
        </a>
    </div>
    <div class="clearfix"></div>
</div>

