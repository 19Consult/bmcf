<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OwnerController;
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

/**
 * here are routes that are available only to unauthorized users
 */
Route::middleware('guest')->group(function () {

    Route::get('/sign-up-founder', [RegisterController::class, 'showRegistrationFormType2'])->name('sign-up-founder');
    Route::post('/sign-up-founder', [RegisterController::class, 'registerType2']);

    Route::get('/sign-up-co-founder', [RegisterController::class, 'showRegistrationFormType3'])->name('sign-up-co-founder');
    Route::post('/sign-up-co-founder', [RegisterController::class, 'registerType2']);


});

/**
 * here are routes that are available only to authorized users
 */
Route::middleware(['auth'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::post('/profile/save', [HomeController::class, 'profileSave'])->name('profileSave');

    // ajax cities
    Route::post('/ajax-get-cities', [CountryController::class, 'ajaxGetCities']);

    Route::get('/logout', function () {
        Auth::logout();
        return redirect(route('welcome'));
    })->name('logout');
});
