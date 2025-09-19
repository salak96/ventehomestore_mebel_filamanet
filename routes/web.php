<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\HomePage;
use App\Livewire\CategoriesPage;
use App\Livewire\ProductsPage;
use App\Livewire\ProductDetailPage;
use App\Livewire\CartPage;
use App\Livewire\CheckoutPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\DetailOrderPage;
use App\Livewire\CancelPage;
use App\Livewire\SuccesPage;

use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\Auth\MyAccountPage;

// --- Public ---
Route::get('/', HomePage::class)->name('home');
Route::get('/', HomePage::class)->name('home');
Route::get('/categories', CategoriesPage::class)->name('categories');   // <-- tambah nama
Route::get('/products', ProductsPage::class)->name('products.index');
Route::get('/products/{slug}', ProductDetailPage::class)->name('products.show');
Route::get('/cart', CartPage::class)->name('cart'); // (opsional, biar navbar gampang)

Route::get('/products', ProductsPage::class)->name('products.index');
Route::get('/products/{slug}', ProductDetailPage::class)->name('products.show');

// --- Guest only (belum login) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class)->name('register');
    Route::get('/forgot', ForgotPasswordPage::class)->name('password.request');
    Route::get('/reset/{token}', ResetPasswordPage::class)->name('password.reset');
});

// --- Auth only (sudah login) ---
Route::middleware('auth')->group(function () {
    // Akun Saya — Pindah ke sini!
    Route::get('/my-account', MyAccountPage::class)->name('my-account');

    Route::get('/checkout', CheckoutPage::class)->name('checkout');
    Route::get('/my-orders', MyOrdersPage::class)->name('my-orders.index');
    Route::get('/my-orders/{order_id}', DetailOrderPage::class)->name('my-orders.show');

    Route::get('/success', SuccesPage::class)->name('success');
    Route::get('/cancel', CancelPage::class)->name('cancel');

    // Logout sebaiknya POST untuk aman (CSRF)
    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('home');
    })->name('logout');
});

// Utility
Route::get('phpinfo', fn () => phpinfo());
