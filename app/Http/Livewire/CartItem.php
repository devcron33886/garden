<?php

namespace App\Http\Livewire;

use Cart;
use App\Product;
use Livewire\Component;

class CartItem extends Component
{
    public $product;
    public $cartItem;
    public $quantity;


    public function mount(Product $product, $cartItem)
    {
        $this->quantity = $cartItem->quantity;
    }

    public function render()
    {
        return view('livewire.cart-item', [
            'product' => $this->product,
            'cartItem' => $this->cartItem
        ]);
    }


    public function update()
    {
        $this->skipRender();

        $product = $this->product;
        $quantity = $this->quantity;
        if ($product->status !== 'Available' || $quantity <= 0)
            session()->flash('error', "Product not available");

        $id = $product->id;
        Cart::remove($id);

        $cartItem = Cart::add([
            'id' => $id,
            'name' => $product->name,
            'quantity' => $quantity,
            'price' => $product->getRealPrice()
        ]);
        $cartItem->associate($product);

        $this->emit('productAdded');
        session()->flash('success', $product->name . " Successfully added to cart");
    }

    public function remove()
    {
        $this->skipRender();

        $product = $this->product;
        Cart::remove($product->id);
        $this->emit('productRemoved');

        session()->flash('success', $product->name . " Successfully removed to cart");
    }
}
