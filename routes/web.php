<?php

use App\Http\Controllers\AdminController;
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

    // Account deletion confirmation
    Route::get('/profile/account-deletion-confirmation', [HomeController::class, 'accountDeletionConfirmation'])->name('AccountDeletionConfirmation');
    Route::post('/profile/send-delete-account', [HomeController::class, 'sendDeleteAccount'])->name('sendDeleteAccount');

    // ajax cities
    Route::post('/ajax-get-cities', [CountryController::class, 'ajaxGetCities']);

    Route::prefix('admin')->middleware(['admin'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users-delete', [AdminController::class, 'usersDelete'])->name('admin.usersDelete');
        Route::post('/users/{id}/delete', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

        Route::post('/users/{id}/block', [AdminController::class, 'block'])->name('admin.users.block');
        Route::post('/users/{id}/unblock', [AdminController::class, 'unblock'])->name('admin.users.unblock');

        Route::get('/users/export-users', [AdminController::class, 'exportUsers'])->name('admin.users.export');
    });


    Route::get('/logout', function () {
        Auth::logout();
        return redirect(route('welcome'));
    })->name('logout');
});
