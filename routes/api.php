<?php

use App\Http\Controllers\Api\V10\AccountTransactionController;
use App\Http\Controllers\Api\V10\FraudController;
use App\Http\Controllers\Api\V10\NewsOfferController;
use App\Http\Controllers\Api\V10\PaymentAccountController;
use App\Http\Controllers\Api\V10\PaymentRequestController;
use App\Http\Controllers\Api\V10\SettingsController;
use App\Http\Controllers\Api\V10\ShopsController;
use App\Http\Controllers\Api\V10\StatementsController;
use App\Http\Controllers\Api\V10\SupportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V10\AuthController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v10')->group(function() {
    Route::middleware(['CheckApiKey'])->group(function () {

        // all apis goes here
        Route::post('/register',                            [AuthController::class, 'register']);
        Route::post('/signin',                              [AuthController::class, 'signin']);
        Route::post('/otp-verification',                    [AuthController::class, 'otpVerification']);
        Route::post('/resend-otp',                          [AuthController::class, 'resendOTP']);
        Route::post('/password/email',                      [AuthController::class, 'sendPasswordResetLinkEmail'])->middleware('throttle:5,1');
        Route::post('/password/reset',                      [AuthController::class, 'resetPassword']);

        Route::group(['middleware'=> ['auth:sanctum']], function () {
            Route::get('/refresh',                          [AuthController::class, 'refresh']);
            Route::get('/profile',                          [AuthController::class, 'profile']);
            Route::put('/update-password',                  [AuthController::class,'updatePassword']);
            Route::post('/sign-out',                        [AuthController::class, 'logout']);

            Route::get('/settings/cod-charges',             [SettingsController::class,'codCharges']);
            Route::get('/settings/delivery-charges',        [SettingsController::class,'deliveryCharges']);


            Route::get('shops/index',                       [ShopsController::class,'index']);
            Route::post('shops/store',                      [ShopsController::class,'store']);
            Route::get('shops/edit/{id}',                   [ShopsController::class,'edit']);
            Route::put('shops/update/{id}',                 [ShopsController::class,'update']);
            Route::delete('shops/delete/{id}',              [ShopsController::class,'delete']);


            Route::get('/payment-accounts/index',           [PaymentAccountController::class,'index']);
            Route::post('/payment-account/store',           [PaymentAccountController::class,'store']);
            Route::get('/payment-account/edit/{id}',        [PaymentAccountController::class,'edit']);
            Route::put('/payment-account/update',           [PaymentAccountController::class,'update']);
            Route::delete('/payment-account/delete/{id}',   [PaymentAccountController::class,'delete']);


            Route::get('/account-transaction/index',        [AccountTransactionController::class,'index']);
            Route::post('/account-transaction/filter',      [AccountTransactionController::class,'filter']);


            Route::get('/statements/index',                 [StatementsController::class,'index']);
            Route::post('/statements/filter',               [StatementsController::class,'filter']);


            Route::get('payment-request/index',             [PaymentRequestController::class,'index']);
            Route::get('payment-request/create',            [PaymentRequestController::class,'create']);
            Route::post('payment-request/store',            [PaymentRequestController::class,'store']);
            Route::get('payment-request/edit/{id}',         [PaymentRequestController::class,'edit']);
            Route::put('payment-request/update/{id}',       [PaymentRequestController::class,'update']);
            Route::delete('payment-request/delete/{id}',    [PaymentRequestController::class,'delete']);


            Route::get('fraud/index',                       [FraudController::class,'index']);
            Route::post('fraud/store',                      [FraudController::class,'store']);
            Route::get('fraud/edit/{id}',                   [FraudController::class,'edit']);
            Route::put('fraud/update/{id}',                 [FraudController::class,'update']);
            Route::delete('fraud/delete/{id}',              [FraudController::class,'destroy']);
            Route::post('fraud/check',                      [FraudController::class,'check']);

            Route::get('news-offer/index',                  [NewsOfferController::class,'index']);

            Route::get('support/index',                     [SupportController::class,'index']);
            Route::get('support/create',                    [SupportController::class,'create']);
            Route::post('support/store',                    [SupportController::class,'store']);
            Route::get('support/edit/{id}',                 [SupportController::class,'edit']);
            Route::put('support/update/{id}',               [SupportController::class,'update']);
            Route::delete('support/delete/{id}',            [SupportController::class,'destroy']);
            Route::get('support/view/{id}',                 [SupportController::class,'view']);
            Route::post('support/reply',                    [SupportController::class,'supportReply']);




        });

    });
});


