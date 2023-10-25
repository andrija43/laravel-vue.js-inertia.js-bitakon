<?php

use App\Http\Controllers\Api\GenerateController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\HomeThreeController;
use App\Http\Controllers\Api\HomeTwoController;
use App\Http\Controllers\Api\PromptCategoryController;
use App\Http\Controllers\Api\PromptController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/account/prompt-category-images', [PromptCategoryController::class, 'index'])
    ->name('api-prompt.category.images');
Route::get('/prompts', [PromptController::class, 'index'])
    ->name('api-prompts.index');
Route::get('/prompt/reviews', [PromptController::class, 'reviews'])
    ->name('api-prompt.reviews');
Route::get('/filtered-prompts', [PromptController::class, 'filter_prompts'])
    ->name('api-filtered-prompts');
Route::get('/home', [HomeController::class, 'index'])
    ->name('api-home');
Route::get('/home-two', [HomeTwoController::class, 'index'])
    ->name('api-home-two');
Route::get('/home-three', [HomeThreeController::class, 'index'])
    ->name('api-home-three');
Route::post('generate',  [GenerateController::class, 'generate'])
    ->name('api-generate');;
