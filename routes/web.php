<?php

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
Auth::routes(['verify' => true]);
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/', function () {
    return view('home');
})->middleware('auth');
Route::get('/sendmail', [App\Http\Controllers\HomeController::class, 'sendmail']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/selectplants', [App\Http\Controllers\HomeController::class, 'selectplants']);

Route::post('/selectplant', [App\Http\Controllers\HomeController::class, 'selectplant']);
Route::get('/myplants', [App\Http\Controllers\HomeController::class, 'myplants']);
Route::post('/unselectplant', [App\Http\Controllers\HomeController::class, 'unselectplant']);

Route::get('/myplant', [App\Http\Controllers\HomeController::class, 'myplant']);

Route::post('/markwatered', [App\Http\Controllers\HomeController::class, 'markwatered']);
