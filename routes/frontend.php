<?php

use App\Http\Controllers\Auth\SocialLoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend as FRONTEND;

Route::get('/',                      [FRONTEND\HomeController::class, 'index']);
Route::get('/about',                 [FRONTEND\HomeController::class, 'about']);
Route::get('/blogs',                 [FRONTEND\BlogController::class, 'index']);
Route::get('/blog/{slug}',           [FRONTEND\BlogController::class, 'show']);
Route::resource('/prompt',           FRONTEND\PromptController::class)->only(['index', 'show'])->names('prompt');
Route::get('/model/{slug}',          [FRONTEND\PromptmodelController::class, 'show'])->name('promptmodel.show');
Route::get('/category/{slug}/{id}',  [FRONTEND\BlogController::class, 'category']);
Route::get('/tag/{slug}/{id}',       [FRONTEND\BlogController::class, 'tag']);

Route::get('/faq',                   [FRONTEND\HomeController::class, 'faq']);
Route::get('/contact',               [FRONTEND\ContactController::class, 'index']);
Route::post('/send-mail',            [FRONTEND\ContactController::class, 'sendMail'])->name('send.mail');
Route::post('/newsletter',           [FRONTEND\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

Route::get('/page/{slug}',           [FRONTEND\HomeController::class, 'page']);
Route::get('/top-sellers',           [FRONTEND\TopSellerController::class, 'index'])->name('top-sellers.index');
Route::get('/collection',            [FRONTEND\CollectionController::class, 'index'])->name('collection.index');
Route::get('/collection/{slug}',     [FRONTEND\CollectionController::class, 'show'])->name('collection.show');

Route::get('/discounts',             [FRONTEND\DiscountController::class, 'index'])->name('discount.index');
Route::get('/profile/{username}',                  [FRONTEND\ProfileController::class, 'index'])->name('profile.show');
Route::get('/profile/{username}/collection',       [FRONTEND\ProfileController::class, 'collection']);
Route::get('/profile/{username}/followers',        [FRONTEND\ProfileController::class, 'followers']);
Route::get('/profile/{username}/followings',       [FRONTEND\ProfileController::class, 'followings']);

