<?php

use App\Models\Payment;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\WebhookController;

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
    ->middleware('payment.limit:' . Payment::GATEWAY_FIRST)
    ->middleware('auth.gateway:' . Payment::GATEWAY_FIRST)
    ->withoutMiddleware([VerifyCsrfToken::class]);

Route::post('/webhook/second', [WebhookController::class, 'second'])
    ->middleware('payment.limit:' . Payment::GATEWAY_SECOND)
    ->middleware('auth.gateway:' . Payment::GATEWAY_SECOND)
    ->withoutMiddleware([VerifyCsrfToken::class]);
