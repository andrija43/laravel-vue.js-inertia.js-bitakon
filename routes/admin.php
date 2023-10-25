<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin as ADMIN;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {

	Route::resource('prompt-model',				ADMIN\PromptModelController::class);
	Route::post('prompt-submodel-store/{id}',   [ADMIN\PromptModelController::class, 'storeSubmodel'])->name('prompt-submodel-store');
	Route::put('prompt-submodel-update/{id}',   [ADMIN\PromptModelController::class, 'updateSubmodel'])->name('prompt-submodel-update');

	Route::get('prompt-sub-models/{id}',        [ADMIN\SubmodelController::class, 'index'])->name('prompt-sub-model.index');
	Route::get('create-prompt-sub-model/{id}',  [ADMIN\SubmodelController::class, 'create'])->name('prompt-sub-models.create');
	Route::post('prompt-sub-models-store/{id}', [ADMIN\SubmodelController::class, 'store'])->name('prompt-sub-models.store');
	Route::get('edit-prompt-sub-models/{id}',   [ADMIN\SubmodelController::class, 'edit'])->name('prompt-sub-models.edit');
	Route::put('prompt-sub-models-update/{id}', [ADMIN\SubmodelController::class, 'update'])->name('prompt-sub-models.update');

	Route::get('prompt/pending',			[ADMIN\PromptController::class, 'pending']);
	Route::get('prompt/disable',			[ADMIN\PromptController::class, 'disable']);
	Route::resource('prompt',			ADMIN\PromptController::class);
	Route::resource('prompt-category',			ADMIN\PromptCategoryController::class);
	Route::resource('prompt-category-image',	ADMIN\PromptCategoryImageController::class);
	Route::get('reports',			[ADMIN\ReportController::class, 'index']);

	Route::resource('role', 	     			ADMIN\RoleController::class);
	Route::resource('admin', 	     			ADMIN\AdminController::class);
	Route::resource('order', 	     			ADMIN\OrderController::class);
	Route::resource('customer',      			ADMIN\CustomerController::class);
	Route::resource('gateways',      			ADMIN\GatewayController::class);
	Route::resource('cron-job',      			ADMIN\CronjobController::class);
	Route::resource('page', 	     			ADMIN\PageController::class);
	Route::resource('blog', 	     			ADMIN\BlogController::class);
	Route::resource('category', 	     		ADMIN\CategoryController::class);
	Route::resource('tag', 	     		        ADMIN\TagController::class);
	Route::resource('language',      			ADMIN\LanguageController::class);
	Route::resource('menu', 	     			ADMIN\MenuController::class);
	Route::patch('/menu-data/{id}', 	       	[ADMIN\MenuController::class, 'updateData'])->name('menu.data.update');
	Route::resource('page-settings', 			ADMIN\SettingsController::class);
	Route::resource('seo', 		     			ADMIN\SeoController::class);
	Route::resource('support', 	     			ADMIN\SupportController::class);
	Route::resource('notification',  			ADMIN\NotifyController::class);

	Route::resource('features',     			ADMIN\FeaturesController::class);
	Route::resource('testimonials',     		ADMIN\TestimonialsController::class);
	Route::resource('review',     		        ADMIN\ReviewController::class);
	Route::resource('collection',     		    ADMIN\CollectionController::class);
	Route::resource('credit-logs',     		    ADMIN\CreditController::class);
	Route::put('update-credit-charge',     		[ADMIN\CreditController::class, 'updateCreditCharge'])->name('updateCreditCharge');
	Route::put('update-image-generate-charge',  [ADMIN\CreditController::class, 'updateImageGenerateCharge'])->name('updateImageGenerateCharge');
	
	Route::resource('faq',     		            ADMIN\FaqController::class);
	Route::resource('slider',     		        ADMIN\SliderController::class);
	Route::resource('team',     		        ADMIN\TeamController::class);
	Route::resource('about',     		        ADMIN\AboutController::class);
	Route::resource('message-transactions',     ADMIN\TransactionController::class);

	Route::resource('developer-settings',     	ADMIN\DeveloperSettingsController::class);
	Route::resource('partner',     				ADMIN\PartnerController::class);
	Route::resource('update',     				ADMIN\UpdateController::class);
	
	Route::get('dashboard', 					[ADMIN\DashboardController::class, 'index'])->name('dashboard.index');
	Route::post('/language/addkey',				[ADMIN\LanguageController::class, 'addKey']);
	Route::post('/menu-update/{id}',		    [ADMIN\MenuController::class, 'storeDate'])->name('menu.content.update');
	Route::get('profile', 						[ADMIN\ProfileController::class, 'settings'])->name('profile.setting');
	Route::put('profile/update/{type}', 		[ADMIN\ProfileController::class, 'update'])->name('profile.update');
	Route::put('/option-update/{key}',		    [ADMIN\OptionController::class, 'update'])->name('option.update');
	Route::get('dashboard-static-data',         [ADMIN\DashboardController::class, 'dashboardData'])->name('dashboard.static');
	Route::get('/wa-server-status',				[ADMIN\DashboardController::class, 'waServerStatus']);
	Route::get('/sales-overview',				[ADMIN\DashboardController::class, 'salesOverView']);


	// Payouts
	Route::resource('payout-methods', ADMIN\PayoutMethodController::class);
	Route::post('payout-methods/delete-all', [ADMIN\PayoutMethodController::class, 'deleteAll'])->name('payout-methods.delete');
	Route::post('payouts/delete-all', [ADMIN\PayoutController::class, 'deleteAll'])->name('payouts.delete');
	Route::get('payouts/approved', [ADMIN\PayoutController::class, 'approved'])->name('payouts.approved');
	Route::get('payouts/reject', [ADMIN\PayoutController::class, 'reject'])->name('payouts.reject');
	Route::resource('payouts', ADMIN\PayoutController::class);
});
