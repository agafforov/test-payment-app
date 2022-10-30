<?php

use App\Models\Payment;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\WebhookController;
use App\Http\Middleware\FirstGetawayAuth;
use App\Http\Middleware\SecondGetawayAuth;
use App\Http\Middleware\FirstGatewayPaymentLimit;
use App\Http\Middleware\SecondGatewayPaymentLimit;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/webhook/first', [WebhookController::class, 'first'])
    ->middleware([FirstGetawayAuth::class])
    ->withoutMiddleware([VerifyCsrfToken::class]);

Route::post('/webhook/second', [WebhookController::class, 'second'])
    ->middleware([SecondGetawayAuth::class])
    ->withoutMiddleware([VerifyCsrfToken::class]);
