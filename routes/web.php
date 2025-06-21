<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Products\Index as ProductsIndex;
use App\Livewire\Orders\Index as OrdersIndex;
use App\Livewire\Reports\Index as ReportsIndex;
use App\Livewire\Dashboard\Index as DashboardIndex;

Route::get('/products', ProductsIndex::class)->name('products.index');

Route::get('/orders', OrdersIndex::class)->name('orders.index');

Route::get('/reports', ReportsIndex::class)->name('reports.index');

Route::get('/dashboard', DashboardIndex::class)->name('dashboard');

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::middleware(['auth'])->group(function () {
//     Route::redirect('settings', 'settings/profile');

//     Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
//     Volt::route('settings/password', 'settings.password')->name('settings.password');
//     Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
// });

// require __DIR__.'/auth.php';
