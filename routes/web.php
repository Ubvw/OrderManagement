<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Livewire\Orders\Index as OrdersIndex;
use App\Livewire\Orders\Edit as OrdersEdit;
use App\Livewire\Orders\Create as OrdersCreate;
use App\Livewire\Dashboard\Index as DashboardIndex;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardIndex::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin: Can do everything
// Admin: Can do everything
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin', fn () => 'Welcome Admin!');
    Route::get('/orders', OrdersIndex::class)->name('orders.index');
    Route::get('/orders/create', OrdersCreate::class)->name('orders.create');
    Route::get('/orders/edit/{order}', OrdersEdit::class)->name('orders.edit');
    Route::get('/products', \App\Livewire\Products\Index::class)->name('products.index');
    Route::get('/reports', \App\Livewire\Reports\Index::class)->name('reports.index');
});

// Cashier: CRUD orders only
Route::middleware(['auth', 'role:Cashier'])->group(function () {
    Route::get('/orders', OrdersIndex::class)->name('orders.index');
    Route::get('/orders/create', OrdersCreate::class)->name('orders.create');
    Route::get('/orders/edit/{order}', OrdersEdit::class)->name('orders.edit');
    // Add delete route if needed
});

// Food Processor: Only update orders
Route::middleware(['auth', 'role:Food Processor'])->group(function () {
    Route::get('/orders/edit/{order}', OrdersEdit::class)->name('orders.edit');
});


require __DIR__.'/auth.php';
