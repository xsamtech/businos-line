<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Middleware\BlockInactiveSavers;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/about', fn (PublicController $c) => $c->legal(0))->name('about');
Route::get('/terms-of-use', fn (PublicController $c) => $c->legal(1))->name('terms');
Route::get('/privacy-policy', fn (PublicController $c) => $c->legal(2))->name('privacy');
Route::get('/locale/{locale}', fn (string $locale) => back())->whereIn('locale', ['en', 'fr', 'es'])->name('locale');
Route::middleware(['auth', BlockInactiveSavers::class])->group(function (): void {
    Route::get('/dashboard', fn () => auth()->user()->isAdministrator() ? redirect()->route('admin.dashboard') : redirect()->route('savings'))->name('dashboard');
    Route::get('/savings', [PublicController::class, 'savings'])->name('savings');
    Route::post('/savings/paypal', [PayPalController::class, 'create'])->name('paypal.create');
    Route::get('/gains', [PublicController::class, 'gains'])->name('gains');
    Route::get('/notifications', [PublicController::class, 'notifications'])->name('notifications');
    Route::get('/account', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/account', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/account', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/paypal/return', [PayPalController::class, 'returned'])->name('paypal.return');
Route::get('/paypal/cancel', [PayPalController::class, 'canceled'])->name('paypal.cancel');
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function (): void {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/roles', [AdminController::class, 'roles'])->name('roles');
    Route::get('/roles/{role}', [AdminController::class, 'roles'])->name('roles.show');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::get('/savings', [AdminController::class, 'savings'])->name('savings');
    Route::get('/savings/{saving}', [AdminController::class, 'savings'])->name('savings.show');
    Route::get('/gains', [AdminController::class, 'gains'])->name('gains');
    Route::get('/gains/{gain}', [AdminController::class, 'gains'])->name('gains.show');
    Route::post('/gains/{gain}/pay', [AdminController::class, 'payGain'])->name('gains.pay');
    Route::get('/abouts', [AdminController::class, 'abouts'])->name('abouts');
    Route::get('/search', [AdminController::class, 'search'])->name('search');
});
require __DIR__.'/auth.php';
