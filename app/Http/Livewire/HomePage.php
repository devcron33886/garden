<?php

namespace App\Http\Livewire;

use Livewire\Component;

class HomePage extends Component
{
    public $slides;

    public $categories;

    public function mount($slides, $categories)
    {
    }

    public function render()
    {
        return view('livewire.home-page');
    }
}
