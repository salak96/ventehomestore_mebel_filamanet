<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)
            ->redirectUrl(route('social.callback', ['provider' => $provider], true))
            ->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)
                ->redirectUrl(route('social.callback', ['provider' => $provider], true))
                ->setHttpClient(new Client(['verify' => false]))
                ->user();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google login failed', [
                'message' => $e->getMessage(),
                'class' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return redirect('/login')->with('error', 'Gagal login dengan Google. Silakan coba lagi.');
        }

        $user = User::where('email', $socialUser->email)->first();

        if ($user) {
            if (!$user->provider_id) {
                $user->update([
                    'provider_name' => $provider,
                    'provider_id' => $socialUser->id,
                    'avatar' => $socialUser->avatar,
                ]);
            }
            Auth::login($user);
            return redirect('/');
        }

        $user = User::create([
            'name' => $socialUser->name,
            'email' => $socialUser->email,
            'password' => bcrypt(Str::random(32)),
            'provider_name' => $provider,
            'provider_id' => $socialUser->id,
            'avatar' => $socialUser->avatar,
        ]);

        Auth::login($user);
        return redirect('/');
    }
}
