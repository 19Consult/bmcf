<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistController;
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
})->name('welcome');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

/**
 * here are routes that are available only to unauthorized users
 */
Route::middleware('guest')->group(function () {
    Route::get('/sign-up-founder', [RegistController::class, 'signUpFounder'])->name('sign-up-founder');
});

/**
 * here are routes that are available only to authorized users
 */
Route::middleware(['auth'])->group(function () {

});
