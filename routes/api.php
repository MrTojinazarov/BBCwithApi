<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BBCController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeOrDislikeController;
use App\Http\Controllers\OvozController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SavolController;
use App\Http\Controllers\VariantController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/', [BBCController::class, 'index']);
    Route::get('/bbc/{id}', [BBCController::class, 'byCategory']);
    Route::get('/single/{id}', [BBCController::class, 'single']);

    Route::get('/admin', [AdminController::class, 'index'])->middleware('check:admin,editor,creator');

    Route::get('/category', [CategoryController::class, 'index'])->middleware('check:admin,editor,creator');
    Route::post('/category', [CategoryController::class, 'store'])->middleware('check:admin,creator');
    Route::put('/category/{category}', [CategoryController::class, 'update'])->middleware('check:admin,editor');
    Route::delete('/category/{category}', [CategoryController::class, 'delete'])->middleware('check:admin,editor');

    Route::get('/post', [PostController::class, 'index'])->middleware('check:admin,editor,creator');
    Route::post('/post', [PostController::class, 'store'])->middleware('check:admin,creator');
    Route::put('/post/{post}', [PostController::class, 'update'])->middleware('check:admin,editor');
    Route::delete('/post/{post}', [PostController::class, 'delete'])->middleware('check:admin,editor');

    Route::post('/posts/{post}/like', [LikeOrDislikeController::class, 'like']);
    Route::post('/posts/{post}/dislike', [LikeOrDislikeController::class, 'dislike']);

    Route::post('/post/{post}/comment', [CommentController::class, 'store']);

    Route::get('/survey', [SavolController::class, 'index'])->middleware('check:admin,creator,editor');
    Route::post('/survey/store', [SavolController::class, 'store'])->middleware('check:admin,creator');
    Route::put('/survey/{id}', [SavolController::class, 'update'])->middleware('check:admin,editor');
    Route::delete('/survey/{id}', [SavolController::class, 'destroy'])->middleware('check:admin,editor');

    Route::delete('/variant/{id}', [VariantController::class, 'destroy'])->middleware('check:admin,editor');

    Route::post('/ovoz', [OvozController::class, 'store']);
    Route::post('/ovoz/update/{id}', [OvozController::class, 'update']);
});

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [LoginController::class, 'register']);
Route::post('logout', [LoginController::class, 'logout']);
