<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Cara Order - AndroidStore')]
class CaraOrderPage extends Component
{
    public function render()
    {
        return view('livewire.cara-order-page');
    }
}
