<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
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
use App\Http\Controllers\InvoiceController;
use App\Livewire\AboutPage;
use App\Livewire\CaraOrderPage;
use App\Livewire\FaqPage;

use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\Auth\MyAccountPage;

Route::get('/storage-serve/{path}', function (string $path) {
    $path = str_replace('%2F', '/', $path);
    if (! Storage::disk('public')->exists($path)) {
        abort(404);
    }
    return response()->file(storage_path('app/public/' . $path));
})->where('path', '.*')->name('storage.serve');

// --- Public (with rate limit) ---
Route::middleware('throttle:300,1')->group(function () {
    Route::get('/', HomePage::class)->name('home');
    Route::get('/categories', CategoriesPage::class)->name('categories');
    Route::get('/products', ProductsPage::class)->name('products.index');
    Route::get('/products/{slug}', ProductDetailPage::class)->name('products.show');
    Route::get('/cart', CartPage::class)->name('cart');

    // --- Info Pages ---
    Route::get('/about', AboutPage::class)->name('about');
    Route::get('/cara-order', CaraOrderPage::class)->name('cara-order');
    Route::get('/faq', FaqPage::class)->name('faq');
});

// --- Guest only (belum login, with stricter rate limit) ---
Route::middleware(['guest', 'throttle:30,1'])->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class)->name('register');
    Route::get('/forgot', ForgotPasswordPage::class)->name('password.request');
    Route::get('/reset/{token}', ResetPasswordPage::class)->name('password.reset');
});

// --- Auth only (sudah login, with rate limit) ---
Route::middleware(['auth', 'throttle:60,1'])->group(function () {
    Route::get('/my-account', MyAccountPage::class)->name('my-account');

    Route::get('/checkout', CheckoutPage::class)->name('checkout');
    Route::get('/my-orders', MyOrdersPage::class)->name('my-orders.index');
    Route::get('/my-orders/{order_id}', DetailOrderPage::class)->name('my-orders.show');
    Route::get('/my-orders/{order_id}/pdf', [InvoiceController::class, 'generate'])->name('my-orders.pdf');

    Route::get('/success', SuccesPage::class)->name('success');
    Route::get('/cancel', CancelPage::class)->name('cancel');

    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('home');
    })->name('logout');
});


