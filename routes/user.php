<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User as USER;




// follow
Route::name('user.')->middleware(['auth', 'user'])->group(function () {

   Route::group(['prefix' => 'account'], function () {
      Route::get('/',                          [USER\AccountController::class, 'index']);
      Route::get('/sales',                     [USER\AccountController::class, 'sales']);
      Route::get('/purchase',                  [USER\AccountController::class, 'purchase']);
      Route::get('/favorite',                  [USER\AccountController::class, 'favorite']);
      Route::get('/followers',                 [USER\AccountController::class, 'followers']);
      Route::get('/followings',                [USER\AccountController::class, 'followings']);
      Route::resource('prompt',                USER\PromptController::class);
      Route::resource('collection',            USER\CollectionController::class);
      Route::patch('/prompt-request-removal/{id}', [USER\PromptController::class, 'updateStatus'])->name('prompt.updateStatus');

      Route::get('/payout/setup/{method_id}',    [USER\PayoutController::class, 'setup'])->name('payout-setup');
      Route::post('/payout/sentotp/{method_id}', [USER\PayoutController::class, 'setnOtp'])->name('payout.otp');
      Route::get('/payout/confirmation',         [USER\PayoutController::class, 'confirmation'])->name('payout.confirmation');
      Route::resource('payout',                   USER\PayoutController::class);
      Route::post('/payout/make-request',        [USER\PayoutController::class, 'makeRequest'])->name('payout.otp.verify');
      Route::get('/payouts/logs',                [USER\PayoutController::class, 'logs'])->name('payout.logs');
      Route::get('/payout-track/{invoice_no}',   [USER\PayoutController::class, 'invoice'])->name('payout.details');
   });

   Route::post('/like',                          [USER\LikeController::class, 'store'])->name('like');
   Route::post('/report',                        [USER\ReportController::class, 'store'])->name('report');
   Route::resource('cart',                       USER\CartController::class);
   Route::get('/checkout',                       [USER\CheckoutController::class, 'index'])->name('checkout.index');
   Route::post('/checkout',                      [USER\CheckoutController::class, 'store'])->name('checkout.store');
   Route::get('/thank-you',                      [USER\CheckoutController::class, 'thank_you'])->name('thank-you');

   Route::resource('review',                        USER\ReviewController::class);
   Route::get('/order/pay/{status}',                [USER\CheckoutController::class, 'status']);

   Route::resource('generate',                      USER\GenerateController::class);
   Route::get('/credit-order/pay/{status}',         [USER\GenerateController::class, 'status']);

   Route::get('/dashboard',                         [USER\DashboardController::class, 'index']);
   Route::get('/dashboard/info',                    [USER\InfoController::class, 'edit'])->name('info.edit');
   Route::patch('/dashboard/info/{id}',             [USER\InfoController::class, 'update'])->name('info.update');
   Route::get('/dashboard/change-password',         [USER\PasswordController::class, 'edit'])->name('change-password.edit');
   Route::patch('/dashboard/change-password/{id}',  [USER\PasswordController::class, 'update'])->name('change-password.update');
   Route::get('/dashboard/orders',                  [USER\OrderController::class, 'index'])->name('orders.index');
   Route::get('/dashboard/orders/{id}',             [USER\OrderController::class, 'show'])->name('orders.show');
   Route::get('/dashboard/orders/{id}/{slug}',      [USER\OrderController::class, 'prompt_show'])->name('orders.prompt.show');
   Route::get('/dashboard/credit-logs',             [USER\CreditlogController::class, 'index'])->name('credit-logs.index');
   Route::resource('/dashboard/notifications',      USER\NotificationController::class)->only(['index', 'update'])->names('notification');
   Route::post('/following',                        [USER\FollowController::class, 'following'])->name('following');
});
