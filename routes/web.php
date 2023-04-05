<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Gateway\Paytm;
use App\Http\Controllers\Gateway\Paypal;
use App\Http\Controllers\Gateway\Razorpay;
use App\Http\Controllers\Gateway\Instamojo;
use App\Http\Controllers\Gateway\Flutterwave;
use App\Http\Controllers\PaymentApiController;
use App\Http\Controllers\HandleApiV1Controller;
use App\Http\Controllers\Front\FrontendController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

  Route::get('currency-rate', [FrontendController::class,'currencyRate'])->name('currency.rate');
   Route::middleware(['maintenance'])->group(function () {

    // ********************************* FRONTEND SECTION *******************************************//
        Route::get('/',                              [FrontendController::class,'index'])->name('front.index');
        Route::get('/about',                         [FrontendController::class,'about'])->name('about');
        Route::get('/frequently-asked-questions',                    [FrontendController::class,'faq'])->name('faq');
        Route::get('/contact',                        [FrontendController::class,'contact'])->name('contact');
        Route::post('/contact',                       [FrontendController::class,'contactSubmit']);
        Route::get('/blogs',                          [FrontendController::class,'blogs'])->name('blogs');
        Route::get('/blog-details/{id}-{slug}',       [FrontendController::class,'blogDetails'])->name('blog.details');
        Route::get('/terms-and-policies/{key}-{slug}',                    [FrontendController::class,'terms_policies'])->name('terms.details');
        Route::get('/pages/{id}-{slug}',               [FrontendController::class,'pages'])->name('pages');
        Route::get('/change-language/{code}',          [FrontendController::class,'langChange'])->name('lang.change');

        Route::match(['get', 'post'],  '/api/v1',[HandleApiV1Controller::class,'handleV1']);
        Route::get('cron-job', [FrontendController::class,'cronJob'])->name('cron');


    });

    Route::post('the/genius/ocean/2441139', [FrontendController::class,'subscription']);
    Route::get('finalize', [FrontendController::class,'finalize']);


    Route::get('notify/paypal',      [Paypal::class,'notify'])->name('paypal.notify');
    Route::post('notify/paytm',      [Paytm::class,'notify'])->name('paytm.notify');
    Route::post('notify/razorpay',   [Razorpay::class,'notify'])->name('razorpay.notify');
    Route::post('notify/flutterwave',[Flutterwave::class,'notify'])->name('flutterwave.notify');
    Route::get('notify/instamojo',   [Instamojo::class,'notify'])->name('notify.instamojo');
    Route::post('notify/coingate',   [Coingate::class,'notify'])->name('notify.coingate');

    Route::get('/maintenance',[FrontendController::class,'maintenance'])->name('front.maintenance');

