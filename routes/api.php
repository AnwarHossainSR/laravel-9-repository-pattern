<?php

use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Blogs\CategoryController;
use App\Http\Controllers\Api\Blogs\CommentController;
use App\Http\Controllers\Api\Blogs\PostController;
use App\Http\Controllers\Api\Notifications\EmailNotificationController;
use App\Http\Controllers\Api\PermissionsAndRoles\PermissionController;
use App\Http\Controllers\Api\PermissionsAndRoles\RoleController;
use App\Http\Controllers\Api\Products\ProductCategoryController;
use App\Http\Controllers\Api\Products\ProductController;
use App\Http\Controllers\Api\Profile\ChangePasswordController;
use App\Http\Controllers\Api\Profile\ProfileController;
use App\Http\Controllers\Api\Samples\SampleController;
use App\Http\Controllers\Api\Users\UserController;
use App\Http\Middleware\AuthGates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function() {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('password.forgot');
    Route::post('reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.reset');
    Route::post('login', [LoginController::class, 'login']);

    Route::get('/notifications/email', [EmailNotificationController::class, 'notify']);

    Route::middleware(['auth:sanctum', AuthGates::class])->group( function () {
        Route::post('update-profile', [ProfileController::class, 'update']);
        Route::post('change-password', [ChangePasswordController::class, 'update']);
        Route::post('logout', [LoginController::class, 'logout']);
        Route::get('samples/list', [SampleController::class, 'list']);
        Route::resource('samples', SampleController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::get('users/list', [UserController::class, 'list']);
        Route::resource('users', UserController::class);
        Route::resource('categories',CategoryController::class);
        Route::get('categories/{category:slug}', [CategoryController::class, 'show']);
        Route::resource('posts', PostController::class);
        Route::get('posts/{post:slug}', [PostController::class, 'show']);
        Route::post('posts/{post:slug}/comments', [CommentController::class, 'store']);
        Route::post('posts/{post:slug}/comments/reply', [CommentController::class, 'storeReply']);
        Route::resource('product-categories', ProductCategoryController::class);
        Route::get('product-categories/{product_category:slug}', [ProductCategoryController::class, 'show']);
        Route::resource('products', ProductController::class);
        Route::get('products/{product:slug}', [ProductController::class, 'show']);
    });

});
