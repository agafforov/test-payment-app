<?php

use App\Http\Controllers\WebhookController;
use App\Http\Middleware\SortRequestParams;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

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

Route::post('/webhook/{merchantName}', [WebhookController::class, 'processPayment'])
    //->middleware([SortRequestParams::class])
    ->withoutMiddleware([VerifyCsrfToken::class])

;
