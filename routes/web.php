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

Route::get('calenders', [CalenderController::class, 'index']);
Route::get('calenders/search', [CalenderController::class, 'searchData']);
Route::post('calenders/action', [CalenderController::class, 'action']);
