<?php

namespace App\Http\Livewire;

use Cart;
use Livewire\Component;

class ShoppingCartPage extends Component
{


    protected $listeners = ['productRemoved' => 'noop', 'productAdded' => 'noop'];

    public function noop()
    {

    }

    public function mount()
    {

    }

    public function render()
    {
        $cart = Cart::getContent();
        return view('livewire.shopping-cart-page', compact('cart'));
    }

    public function removeAll()
    {
        Cart::clear();

        $this->emit('productRemoved');
    }
}
