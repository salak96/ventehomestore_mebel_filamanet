<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Tentang Kami - AndroidStore')]
class AboutPage extends Component
{
    public function render()
    {
        return view('livewire.about-page');
    }
}
