<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Predis\Configuration\Option\Prefix;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Post\PostController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Admin\AdminController;
use App\Http\Controllers\Admin\GeneralSearchController;
use App\Http\Controllers\Admin\Contact\ContactController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Settings\SettingsController;
use App\Http\Controllers\Admin\Settings\RelatedSiteController;
use App\Http\Controllers\Admin\Notification\NotificationController;
use App\Http\Controllers\Admin\Auth\Password\ResetPasswordController;
use App\Http\Controllers\Admin\Authorization\AuthorizationController;
use App\Http\Controllers\Admin\Auth\Password\ForgetPasswordController;

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
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    //*********** Login Routes*******************
    Route::controller(LoginController::class)->group(function () {

        Route::get('login', 'showLoginForm')->name('login.show');
        Route::post('login/check', 'checkAuth')->name('login.check');
        Route::post('logout', 'logout')->name('logout');
    });
    //*********** End Login Routes*****************

    //*********** Password Routes******************
    Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
        Route::controller(ForgetPasswordController::class)->group(function () {
            Route::get('email',  'showEmailForm')->name('showEmailForm');
            Route::post('email',  'sendOtp')->name('sendOtp');
            Route::get('verify/{email}',  'showOtpForm')->name('showOtpForm');
            Route::post('verify',  'verifyOtp')->name('verifyOtp');
        });

        Route::controller(ResetPasswordController::class)->group(function () {

            Route::get('reset/{email}', 'resetForm')->name('resetForm');
            Route::post('reset', 'reset')->name('reset');
        });
    });
    //*********** End Password Routes*******************
});




Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth:admin' , 'CheckAdminStatus']], function () {
  
    Route::get('home', [HomeController::class, 'index'])->name('home');
    // General Search Route
    Route::get('search', [GeneralSearchController::class, 'search'])->name('search');
    // End General Search Route
    Route::resource('authorizations', AuthorizationController::class);
    Route::resource('users',      UserController::class);
    Route::resource('posts',      PostController::class);
    Route::resource('categories',      CategoryController::class);
    Route::resource('admins',      AdminController::class);
    Route::resource('related-site', RelatedSiteController::class);



    Route::get('users/status/{id}', [UserController::class, 'changeStatus'])->name('users.changeStatus');
    Route::get('posts/status/{id}', [PostController::class, 'changeStatus'])->name('posts.changeStatus');
    Route::get('posts/comment/delete/{id}', [PostController::class, 'deleteComment'])->name('posts.deleteComment');
    Route::post('posts/image/delete/{image_id}', [PostController::class, 'deletePostImage'])->name('posts.image.delete');
    Route::get('categories/status/{id}', [CategoryController::class, 'changeStatus'])->name('categories.changeStatus');
    Route::get('admins/status/{id}', [AdminController::class, 'changeStatus'])->name('admins.changeStatus');

    //*********** Settings Routes*****************
    Route::controller(SettingsController::class)->prefix('settings')->as('settings.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'update')->name('update');
    });
    //*********** End Settings Routes**************
    //*********** Profile Routes*******************
    Route::controller(ProfileController::class)->prefix('profile')->as('profile.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'update')->name('update');
    });
    //*********** End Profile Routes***************

    //*********** Contact Routes*******************
    Route::controller(ContactController::class)->prefix('contacts')->as('contacts.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });

    //*********** Notification Routes***************
    Route::controller(NotificationController::class)->prefix('notifications')->as('notifications.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/destroy/{id}', 'destroy')->name('destroy');
        Route::get('/deleteAll', 'deleteAll')->name('deleteAll');
    });
    //*********** End Notification Routes************

   



});

Route::get('wait' , function(){
    return view('Admin.wait');
})->name('admin.wait');

