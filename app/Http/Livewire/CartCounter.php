<?php

namespace App\Http\Livewire;

use Cart;
use Livewire\Component;

class CartCounter extends Component
{
    protected $listeners = ['productAdded' => 'update', 'productRemoved' => 'update'];

    public function update()
    {
    }

    public function render()
    {
        return view('livewire.cart-counter', [
            'count' => Cart::getTotalQuantity(),
        ]);
    }
}
