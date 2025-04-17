<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\RelatedNewsController;
use App\Http\Controllers\Api\Account\PostController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Account\SettingController;
use App\Http\Controllers\Api\Auth\EmailVerifyController;
use App\Http\Controllers\Api\Account\NotificationController;
use App\Http\Controllers\Api\Auth\Password\ResetPasswordController;
use App\Http\Controllers\Api\Auth\Password\ForgotPasswordController;
use App\Http\Controllers\Api\Account\SettingController as AccountSettingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum' , 'CheckUserStatus' , 'CheckEmailVerifyApi'])->prefix('account')->group(function () {
    Route::get('/user', function (Request $request) {
        return UserResource::make($request->user());
    });

    Route::put('setting/{user_id}', [SettingController::class, 'updateSetting']);
    Route::put('password/{user_id}', [SettingController::class, 'updatePassword']);

    Route::controller(PostController::class)->prefix('posts')->group(function () {
        Route::get('/', 'getUserPosts');
        Route::post('store', 'storeUserPost');
        Route::put('update/{post_id}', 'updateUserPost');
        Route::delete('destroy/{post_id}', 'destroyUserPosts');

        Route::get('comments/{post_id}', 'getPostComments');
        Route::post('comments/store', 'storePostComment');
    });

    Route::get('/notifications' , [NotificationController::class , 'getNotifications']); 
    Route::get('/notifications/read/{id}' , [NotificationController::class , 'readNotifications']); 
});
//  *************************** Register Routes******************************
Route::post('auth/register', [RegisterController::class, 'register']);

//  *************************** Login Routes****************************** 
Route::controller(LoginController::class)->group(function () {
    Route::post('auth/login', 'login') ;
    Route::delete('auth/logout', 'logout');
});

//  *************************** forgot Password Routes******************************
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::post('password/email', 'sendOtp');
});
//  *************************** Reset Password Routes******************************
Route::controller(ResetPasswordController::class)->group(function () {
    Route::post('password/reset', 'resetPassword');
});

//  *************************** Email verify Routes******************************

Route::middleware('auth:sanctum')->controller(EmailVerifyController::class)->group(function () {
    Route::post('auth/email/verify',  'emailVerify');
    //  لو محتاج ابعت كود تاني
    Route::get('auth/email/verify',  'sendOtpAgain');
});

//  *************************** Home Page Routes******************************

Route::controller(GeneralController::class)->group(function () {
    Route::get('posts/{keyword?}',  'getPosts');
    Route::get('posts/show/{slug}',  'showPost');
    Route::get('posts/comments/{slug}',  'getPostComments');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('categories',  'getCategories');
    Route::get('category/{slug}/posts',  'getCategoryPosts');
});

Route::get('related-news', [RelatedNewsController::class, 'getRelatedNews']);

Route::post('contact/store', [ContactController::class, 'contactStore'])->middleware('throttle:contact');

Route::get('settings', [SettingController::class, 'getSettings']);
