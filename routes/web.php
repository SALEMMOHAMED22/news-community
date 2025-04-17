<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\PostController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\frontend\CategoryController;
use App\Http\Controllers\frontend\NewsSubsciberController;
use App\Http\Controllers\frontend\dashboard\ProfileController;
use App\Http\Controllers\frontend\dashboard\SettingController;
use App\Http\Controllers\frontend\dashboard\NotificationController;

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


Route::redirect('/' , '/home');

Route::group([
    'as'=>'frontend.',
], function(){

    // Home Page :
    Route::get('/home', [HomeController::class , "index"])->name("index");

    // subscriber Route :
      Route::post('news-subscribe' , [NewsSubsciberController::class , 'store'])->name('news.subscribe');

    // Show Category Route :
    Route::get('category/{slug}' , CategoryController::class)->name('category.posts');


    // Post Routes :
    Route::controller(PostController::class)->name('post.')->prefix('post')->group(function(){
        Route::get('/{slug}' ,  'show')->name('show');
        Route::get('/comments/{slug}' ,  'getAllPosts')->name('getAllComments');
        Route::post('comments/store' ,  'saveComment')->name('comments.store');

    });
 
    // Contact Routes : 
    Route::controller(ContactController::class)->name('contact.')->prefix('contact-us')->group(function(){

        Route::get('/' ,  'index')->name('index');
        Route::post('/store' , 'store')->name('store');
 
    });

    Route::match(['get','post'] , '/search' , SearchController::class )->name('search');


    // dasshboard 

    Route::prefix('user/')->name('dashboard.')->middleware('auth:web' , 'verified' , 'CheckUserStatus' )->group(function(){

        // profile controller 
        Route::controller(ProfileController::class)->group(function(){
            Route::get('profile' , 'index')->name('profile');
            Route::post('post/store' , 'storepost')->name('post.store');
            Route::delete('post/delete' , 'deletePost')->name('post.delete');
            Route::get('post/getComments/{id}' , 'getComments')->name('post.getComments');
            Route::get('post/edite/{slug}' , 'editePost')->name('post.edite');
            Route::post('post/update' , 'updatePost')->name('post.update');
            Route::post('image/delete/{image_id}' , 'deleteImage')->name('post.deleteImage');

        });

        // setting 
        Route::prefix('setting')->controller(SettingController::class)->group(function(){

            Route::get('/' , 'index')->name('setting');
            Route::post('/update' , 'update')->name('setting.update');
            Route::post('/changePassword' , 'changePassword')->name('setting.changePassword');

        });


        // notification routes 

        Route::prefix('notification')->controller(NotificationController::class)->group(function(){

            Route::get('/' , 'index')->name('notification.index');
            Route::get('/read-all' , 'readAll')->name('notification.readAll');
            Route::post('/delete' , 'delete')->name('notification.delete');
            Route::get('/deleteAll' , 'deleteAll')->name('notification.deleteAll');

        });
    });

    Route::get('wait' , function(){
        return view('frontend.wait');
    })->name('wait');

}

);
Route::get('email/verify', [VerificationController::class , 'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [VerificationController::class , 'verify'])->name('verification.verify');
Route::post('email/resend', [VerificationController::class , 'resend'])->name('verification.resend');

Route::get('/test' , function(){
    return view('frontend.dashboard.profile');
});
Route::get('auth/{provider}/redirect' , [SocialLoginController::class , 'redirect'])->name('auth.provider.redirect');
Route::get('auth/{provider}/callback' , [SocialLoginController::class , 'callback'])->name('auth.provider.callback');

Auth::routes();

