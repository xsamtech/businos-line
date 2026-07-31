<?php

use App\Http\Controllers\PayPalController;
use Illuminate\Support\Facades\Route;

Route::post('/paypal/webhook', [PayPalController::class, 'webhook'])->middleware('throttle:120,1')->name('api.paypal.webhook');
