<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('FAQ - AndroidStore')]
class FaqPage extends Component
{
    public function render()
    {
        return view('livewire.faq-page');
    }
}
