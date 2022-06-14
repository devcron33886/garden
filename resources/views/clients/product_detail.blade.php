@extends('layouts.app')
@section('styles')
    <style>
        html, body {
            background-color: #FCFCFC;
        }

        .container-div {
            max-height: 200px;
            overflow-y: hidden
        }

        .ratings {
            color: grey;
        }

        .grow {
            transition: all .2s ease-in-out;
        }

        .product-name {
            color: #449D44;
        }

        .grow:hover {
            transform: scale(1.1);
        }

        .item.list-group-item {
            width: 100%;
            background-color: #fff;
            margin-bottom: 10px;
        }


    </style>
@endsection
@section('title')
    Product
@endsection
@section('content')
    <br>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <img class="img-responsive img-thumbnail rounded-sm shadow-sm"
                             src="{{ $product->image_url }}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="">
                        <h3>{{ $product->name }}</h3>
                        <div class="h2">
                            RWF {{ number_format($product->getRealPrice(),1) }}
                            @if($product->discount>0)
                                <del class="product-old-price text-danger">
                                    <span>{{ number_format($product->price) }}</span>
                                </del>
                            @endif
                            <small>{{ $product->measure }}</small>
                        </div>
                        <div style="padding: 20px 0">
                            @if($product->status==='Available')
                                <form action="{{ route('cart.addToCart',['id'=>$product->id]) }}"
                                      class="form-inline">
                                    <div class="form-group form-group-sm">
                                        <label for="qty{{$product->id}}"></label>
                                        <input style="width: 60px" min="0.5" size="10"
                                               value="1" type="text"
                                               max="{{ $product->qty }}" name="qty"
                                               class="form-control flat"
                                               placeholder="Qty"
                                               id="qty{{$product->id}}">
                                    </div>
                                    <button type="submit"
                                            class="btn btn-cart text-uppercase btn-sm flat" {{ $product->qty <=0 ? 'disabled':'' }}>
                                        <i class="ti ti-shopping-cart"></i>
                                        Add to cart
                                    </button>
                                </form>
                            @else
                                <span class="label label-warning">
                                    <i class="fa fa-info-circle"></i> Out Of Stock
                                </span>
                            @endif
                        </div>
                        <div>
                            <p>
                                {{$product->description}}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="strong bold text-center text-uppercase">
                        <span>Products you may like</span>
                    </h4>
                </div>
                @foreach($alsoBoughtProducts as $item)
                    <div class="col-md-3 col-sm-6">
                        <livewire:card-product :product="$item" label=""/>
                    </div>
                @endforeach
            </div>
        </div>
    </div>



@endsection
