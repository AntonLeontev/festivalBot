<?php

use App\Http\Controllers\DishController;
use App\Http\Controllers\FrontController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use SergiX44\Nutgram\Nutgram;

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

Route::get('/test', [DishController::class, 'store']);
Route::get('/menu', [DishController::class, 'index']);
Route::post('/webhook', FrontController::class);
