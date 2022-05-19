<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\listController;


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
    return view('list');
});


Route::get('/list', [listController::class,'index']);
Route::post('/contact-store', [listController::class,'ContactStore']);
Route::post('/contact-edit', [listController::class,'ContactEdit']);
Route::post('/ContactUpdate', [listController::class,'ContactUpdate']);
Route::post('/ContactDelete', [listController::class,'ContactDelete']);
