<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cron as CRON;

Route::group(['prefix' => 'cron', 'as' => 'cron.'], function () {

    Route::get('/calculate-seller-order-payment', [CRON\SellerController::class, 'calculateOrder']);
    Route::get('/calculate-discounted-price',     [CRON\DiscountController::class, 'calculateDiscount']);
    Route::get('/execute-jobs',                   [CRON\CronController::class, 'executeJob']);
});
