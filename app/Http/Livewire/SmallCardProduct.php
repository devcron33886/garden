<?php

namespace App\Http\Livewire;

use App\CartService;
use App\Product;
use Livewire\Component;

use Cart;

class SmallCardProduct extends Component
{
    public $product;

    public function mount(Product $product)
    {
    }

    public function render()
    {
        return view('livewire.small-card-product', [
            'added' => Cart::get($this->product->id)
        ]);
    }
}
