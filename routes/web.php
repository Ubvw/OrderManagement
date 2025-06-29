<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Livewire\Orders\Index as OrdersIndex;
use App\Livewire\Orders\Edit as OrdersEdit;
use App\Livewire\Orders\Create as OrdersCreate;
use App\Livewire\Dashboard\Index as DashboardIndex;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/', [AuthenticatedSessionController::class, 'store']);

// log out function
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect(to: '/');
})->name('logout');

Route::get('/dashboard', DashboardIndex::class)
    ->middleware(['auth', 'verified', 'role:Admin'])
    ->name('dashboard');
    
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Orders: shared by Admin, Cashier, Food Processor
Route::middleware(['auth', 'role:Admin,Cashier,Food Processor'])->group(function () {
    Route::get('/orders', OrdersIndex::class)->name('orders.index');
    Route::get('/orders/edit/{order}', OrdersEdit::class)->name('orders.edit');
});

// Only Admin and Cashier can create orders
Route::middleware(['auth', 'role:Admin,Cashier'])->group(function () {
    Route::get('/orders/create', OrdersCreate::class)->name('orders.create');
});

// Admin: Can do everything else
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin', fn () => 'Welcome Admin!');
    Route::get('/products', \App\Livewire\Products\Index::class)->name('products.index');
    Route::get('/reports', \App\Livewire\Reports\Index::class)->name('reports.index');
    Route::get('/users', \App\Livewire\Users\Index::class)->name('users.index');
});

require __DIR__.'/auth.php';