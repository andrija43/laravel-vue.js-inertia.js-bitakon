<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin as ADMIN;
use App\Http\Controllers\LocaleController;

Route::patch('set-locale/{locale}', [LocaleController::class, 'update'])->name('set-locale');


require __DIR__ . '/auth.php';
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {

    Route::resource('plan',                      ADMIN\PlanController::class);
    Route::resource('role',                      ADMIN\RoleController::class);
    Route::resource('admin',                     ADMIN\AdminController::class);
    Route::resource('order',                     ADMIN\OrderController::class);
    Route::resource('customer',                  ADMIN\CustomerController::class);
    Route::resource('gateways',                  ADMIN\GatewayController::class);
    Route::resource('cron-job',                  ADMIN\CronjobController::class);
    Route::resource('page',                      ADMIN\PageController::class);
    Route::resource('blog',                      ADMIN\BlogController::class);
    Route::resource('category',                  ADMIN\CategoryController::class);
    Route::resource('tag',                       ADMIN\TagController::class);
    Route::resource('language',                  ADMIN\LanguageController::class);
    Route::resource('menu',                      ADMIN\MenuController::class);
    Route::resource('page-settings',             ADMIN\SettingsController::class);
    Route::resource('seo',                       ADMIN\SeoController::class);
    Route::resource('support',                   ADMIN\SupportController::class);
    Route::resource('notification',              ADMIN\NotifyController::class);

    Route::resource('features',                 ADMIN\FeaturesController::class);
    Route::resource('testimonials',             ADMIN\TestimonialsController::class);
    Route::resource('faq',                      ADMIN\FaqController::class);
    Route::resource('team',                     ADMIN\TeamController::class);
    Route::resource('about',                    ADMIN\AboutController::class);
    Route::resource('message-transactions',     ADMIN\TransactionController::class);

    Route::resource('developer-settings',       ADMIN\DeveloperSettingsController::class);
    Route::resource('partner',                  ADMIN\PartnerController::class);
    Route::resource('update',                   ADMIN\UpdateController::class);

    Route::get('dashboard',                     [ADMIN\DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/language/addkey',             [ADMIN\LanguageController::class, 'addKey']);
    Route::post('/menu-update/{id}',            [ADMIN\MenuController::class, 'storeDate'])->name('menu.content.update');
    Route::get('profile',                       [ADMIN\ProfileController::class, 'settings']);
    Route::put('profile/update/{type}',         [ADMIN\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/option-update/{key}',          [ADMIN\OptionController::class, 'update'])->name('option.update');
    Route::get('dashboard-static-data',         [ADMIN\DashboardController::class, 'dashboardData'])->name('dashboard.static');
    Route::get('/sales-overview',               [ADMIN\DashboardController::class, 'salesOverView']);
});
//**======================== Payment Gateway Route Group for merchant ====================**//
Route::group(['middleware' => ['auth', 'web']], function () {
    Route::get('/payment/paypal', '\App\Gateway\Paypal@status');
    Route::post('/stripe/payment', '\App\Gateway\Stripe@status')->name('stripe.payment');
    Route::get('/stripe', '\App\Gateway\Stripe@view')->name('stripe.view');
    Route::get('/payment/mollie', '\App\Gateway\Mollie@status');
    Route::post('/payment/paystack', '\App\Gateway\Paystack@status')->name('paystack.status');
    Route::get('/paystack', '\App\Gateway\Paystack@view')->name('paystack.view');
    Route::get('/payment/mercado', '\App\Gateway\Mercado@status')->name('mercadopago.status');
    Route::get('/razorpay/payment', '\App\Gateway\Razorpay@view')->name('razorpay.view');
    Route::post('/razorpay/status', '\App\Gateway\Razorpay@status');
    Route::get('/payment/flutterwave', '\App\Gateway\Flutterwave@status');
    Route::get('/payment/thawani', '\App\Gateway\Thawani@status');
    Route::get('/payment/instamojo', '\App\Gateway\Instamojo@status');
    Route::get('/payment/toyyibpay', '\App\Gateway\Toyyibpay@status');
    Route::get('/manual/payment', '\App\Gateway\CustomGateway@status');
    Route::get('payu/payment', '\App\Gateway\Payu@view')->name('payu.view');
    Route::post('payu/status', '\App\Gateway\Payu@status')->name('payu.status');
});

//**======================== Installler Route Group ====================**//
Route::resource('install',    App\Http\Controllers\Installer\InstallerController::class);
Route::post('install/verify', [App\Http\Controllers\Installer\InstallerController::class,'verify'])->name('install.verify');
Route::post('install/migrate', [App\Http\Controllers\Installer\InstallerController::class,'migrate'])->name('install.migrate');
