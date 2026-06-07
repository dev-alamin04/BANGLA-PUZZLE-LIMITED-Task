<?php

// Payment Routes

use App\Http\Controllers\Web\Backend\Quest\QuestController;
use App\Http\Controllers\Web\Payment\StripePaymentController;

use Illuminate\Support\Facades\Route;

Route::prefix('payments')->name('payments.')->group(function () {
    Route::get('/success', [StripePaymentController::class, 'success'])->name('success');
    Route::get('/cancel', [StripePaymentController::class, 'cancel'])->name('cancel');
});

require __DIR__ . '/auth.php';
