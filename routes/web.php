<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\RegistController;
use App\Http\Controllers\CustomMessagesController;
use Illuminate\Support\Facades\Route;

//use Chatify;
use Chatify\ChatifyServiceProvider;
use Chatify\ChatifyMessenger;

//use App\Providers\BroadcastServiceProvider;
//use Exception;

use Illuminate\Support\Facades\Broadcast;

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

Auth::routes(['verify' => true]);

/**
 * here are routes that are available only to unauthorized users
 */
Route::middleware('guest')->group(function () {

    Route::get('/sign-up-founder', [RegisterController::class, 'showRegistrationFormType2'])->name('sign-up-founder');
    Route::post('/sign-up-founder', [RegisterController::class, 'registerType2']);

    Route::get('/sign-up-co-founder', [RegisterController::class, 'showRegistrationFormType3'])->name('sign-up-co-founder');
    Route::post('/sign-up-co-founder', [RegisterController::class, 'registerType2']);


});

    Route::group(['prefix' => 'chat', 'middleware' => 'web'], function () {
        Route::get('/search', [CustomMessagesController::class, 'search'])->name('search');
        Route::post('/idInfo', [CustomMessagesController::class, 'idFetchData']);
        Route::post('/favorites', [CustomMessagesController::class, 'getFavorites']);
    });

/**
 * here are routes that are available only to authorized users
 */
Route::middleware(['auth'])->group(function () {

    //Dashboard
    Route::get('/dashboard', [OwnerController::class, 'dashboardOwner'])->name('dashboardOwner');
    Route::get('/dashboard-angel', [InvestorController::class, 'dashboardInvestor'])->name('dashboardInvestor');

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/home-angel', [InvestorController::class, 'indexInvestor'])->name('homeInvestor');


    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::post('/profile/save', [HomeController::class, 'profileSave'])->name('profileSave');

    // Account deletion confirmation
    Route::get('/profile/account-deletion-confirmation', [HomeController::class, 'accountDeletionConfirmation'])->name('AccountDeletionConfirmation');
    Route::post('/profile/send-delete-account', [HomeController::class, 'sendDeleteAccount'])->name('sendDeleteAccount');

    // ajax cities
    Route::post('/ajax-get-cities', [CountryController::class, 'ajaxGetCities']);

    // project
    Route::get('/create-project', [OwnerController::class, 'createProject'])->name('createProject');
    Route::post('/create-project/save', [OwnerController::class, 'saveProject'])->name('saveProject');

    Route::get('/project/{id}', [OwnerController::class, 'viewProject'])->name('viewProject');

    Route::post('/project/pda-project-save', [InvestorController::class, 'saveNdaProject'])->name('saveNdaProject');


    Route::get('/nda-list', [OwnerController::class, 'ndaList'])->name('ndaList');
    Route::get('/nda-list-angel', [InvestorController::class, 'ndaListInvestor'])->name('ndaListInvestor');

    Route::get('/nda-download/{nda_id}', [InvestorController::class, 'downloadNda'])->name('downloadNda');

    // project-favorites (The page is created, and the functionality is hidden)
    //Route::get('/project-favorites', [InvestorController::class, 'viewProjectFavorites'])->name('viewProjectFavorites');

//    Route::get('/project-list', [OwnerController::class, 'listProject'])->name('listProject');

    Route::post('/project/counter-projects-views', [InvestorController::class, 'counterProjectsViews'])->name('counterProjectsViews');
    Route::post('/project/favorite', [InvestorController::class, 'favoriteProject'])->name('favoriteProject');

    Route::post('/project/ajax-project-details', [OwnerController::class, 'ajaxProjectDetails'])->name('ajaxProjectDetails');

    Route::post('/project/seen-nda-project', [OwnerController::class, 'seenNdaProject'])->name('seenNdaProject');

    Route::post('/project/confirm-nda-project', [OwnerController::class, 'confirmNdaProject'])->name('confirmNdaProject');
    Route::post('/project/rejected-nda-project', [OwnerController::class, 'rejectedNdaProject'])->name('rejectedNdaProject');

    Route::get('/project/delete-project/{id_project}', [OwnerController::class, 'deleteProjectPreview'])->name('deleteProjectPreview');
    Route::post('/project/delete-project', [OwnerController::class, 'deleteProject'])->name('deleteProject');

    Route::post('/notifications/{id}/mark-as-read', [HomeController::class, 'markAsRead'])->name('markAsRead');

    Route::post('/report-problem', [HomeController::class, 'reportProblem'])->name('reportProblem');

    Route::prefix('admin')->middleware(['admin'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users-delete', [AdminController::class, 'usersDelete'])->name('admin.usersDelete');
        Route::post('/users/{id}/delete', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

        Route::post('/users/{id}/block', [AdminController::class, 'block'])->name('admin.users.block');
        Route::post('/users/{id}/unblock', [AdminController::class, 'unblock'])->name('admin.users.unblock');

        Route::get('/users/export-users', [AdminController::class, 'exportUsers'])->name('admin.users.export');

        Route::get('/category/list', [AdminController::class, 'categoryList'])->name('admin.category.list');
        Route::get('/category/create', [AdminController::class, 'categoryCreate'])->name('admin.category.create');
        Route::post('/category/create', [AdminController::class, 'categoryCreate']);
        Route::get('/category/{id}', [AdminController::class, 'categoryEdit'])->name('admin.category.edit');

        Route::post('/category/{id}/save', [AdminController::class, 'categorySave'])->name('admin.category.save');
        Route::get('/category/{id}/delete', [AdminController::class, 'categoryDelete'])->name('admin.category.delete');


        Route::get('/settings', [AdminController::class, 'settingsPage'])->name('admin.settingsPage');
        Route::post('/settings/save', [AdminController::class, 'settingsPageSave'])->name('admin.settingsPageSave');

        Route::get('/admin-settings', [AdminController::class, 'adminSettingsPage'])->name('admin.adminSettingsPage');
        Route::post('/admin-settings/save', [AdminController::class, 'adminSettingsPageSave'])->name('adminSettingsPageSave');

        Route::get('/reports', [AdminController::class, 'showReports'])->name('admin.reports');
    });


    Route::get('/logout', function () {
        Auth::logout();
        return redirect(route('welcome'));
    })->name('logout');
});
