<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;

#[Title('Register')]
class RegisterPage extends Component
{
    public $name;
    public $email;
    public $password;
    public $recaptcha_token = null;

    protected function validateRecaptcha(): bool
    {
        if (!$this->recaptcha_token) {
            return false;
        }

        try {
            $response = \Illuminate\Support\Facades\Http::asForm()
                ->withoutVerifying()
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => config('recaptcha.api_secret_key'),
                    'response' => $this->recaptcha_token,
                ]);

            return $response->json('success') ?? false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:8|max:20',
            'recaptcha_token' => 'required',
        ], [
            'recaptcha_token.required' => 'Harap verifikasi bahwa Anda bukan robot.',
        ]);

        if (!$this->validateRecaptcha()) {
            $this->addError('recaptcha', 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.');
            return;
        }

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        auth()->login($user);

        return redirect()->intended();
    }

    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
