<?php

use App\Http\Controllers\CalenderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('calenders')->group(function () {
    Route::get('/', [CalenderController::class, 'index']);
    Route::post('/search', [CalenderController::class, 'searchData']);
    Route::post('/action', [CalenderController::class, 'action']);
});