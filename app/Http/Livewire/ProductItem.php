<?php

namespace App\Http\Livewire;


use App\Product;
use Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ProductItem extends Component
{
    public $product;
    public $quantity;

    public function mount(Product $product)
    {
        $this->quantity = 1;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.product-item', [
            'added' => Cart::get($this->product->id)
        ]);
    }

    public function remove()
    {
        Cart::remove($this->product->id);
        $this->emit('productRemoved');

        session()->flash('success', $this->product->name . " Successfully removed to cart");
    }

    public function add()
    {
        $product = $this->product;
        $quantity = $this->quantity;

        if ($product->status !== 'Available' || $quantity <= 0)
        {
            session()->flash('error', "Product not available");
            return back();
        }

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
        return back();
    }
}
