<?php
namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class MyAccountPage extends Component
{
    public $name;
    public $email;

    public $current_password;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        $this->name  = $user->name ?? '';
        $this->email = $user->email ?? '';
    }

    public function updateProfile()
    {
        $this->validate([
            'name'  => 'required|string|min:2',
            'email' => 'required|email:rfc,dns|unique:users,email,' . Auth::id(),
        ]);

        $user = \App\Models\User::find(Auth::id());
        $user->name  = $this->name;
        $user->email = $this->email;
        $user->save();
        

        session()->flash('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password'      => 'required',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = \App\Models\User::find(Auth::id());

        if (! Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Kata sandi saat ini tidak sesuai.');
            return;
        }

        $user->password = Hash::make($this->password);
        $user->save();

        $this->reset(['current_password', 'password', 'password_confirmation']);
        session()->flash('success', 'Kata sandi berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.auth.my-account');
    }
}
