<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Password;

#[Title('Lupa Password')]
class ForgotPasswordPage extends Component
{
    public $email;  
    
    public function save()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email|max:255'
        ]);

        $status = Password::sendResetLink(['email' => $this->email]);

        if($status === Password::RESET_LINK_SENT) {
            session()->flash('success', 'Link reset password telah dikirim ke email Anda.');
            $this->email = '';
        } else {
            session()->flash('error', 'Gagal mengirim link reset. Silakan coba lagi.');
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password-page');
    }
}
