<tr wire:loading.class.delay="loading">
    <td class="hidden-xs">
        <h4>
            <a href="{{ asset("uploads/products/" .$product->image ) }}">
                <img src="{{ asset("uploads/products/" .$product->image ) }}"
                     alt="{{ $cartItem->name }}"
                     class="img-responsive img-thumbnail img-circle"
                     style="height: 50px ;width: 50px;object-fit: cover">
            </a>
        </h4>
    </td>
    <td>
        <h5>{{ $cartItem->name }}</h5>
    </td>
    <td>
        <p>
            {{ number_format($cartItem->price) }}
            <small>Rwf</small> /
            {{ $product->measure }}
        </p>
    </td>
    <td>
        <form class="form-inline"
              action="{{ route('cart.increment',['id'=>$cartItem->id]) }}">

            <div class="input-group">
                <input wire:model.defer="quantity" type="text" class="form-control" name="qty"
                       placeholder="Quantity" min="0.5" wire:loading.attr="disabled" style="width: 70px;"
                       value="">
                <span class="input-group-btn">
                <button
                        wire:loading.attr="disabled"
                        class="btn btn-default btn-cart text-capitalize"
                        title="Click here to update Quantity."
{{--                        wire:click="update"--}}
                        data-toggle="tooltip" data-placement="right"
                        type="submit">
                    <i class="fa fa-plus"></i>
                </button>
              </span>
            </div>
        </form>

    </td>

    <td>
        <p>
            {{ number_format($cartItem->getPriceSum()) }}
            <small>Rwf</small>
        </p>
    </td>

    <td>
        <button class="cart-remove-btn btn-xs btn-default btn" wire:loading.attr="disabled"
                title="Click here to remove Item." wire:click="remove"
                data-toggle="tooltip" data-placement="left">
            <i class="fa fa-times"></i>
        </button>
    </td>
</tr>

