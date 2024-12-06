<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users/search', [UserController::class, 'searchAndFilter'])->name('user.search');
Route::get('/users/{id}/reviews', [UserController::class, 'userReviews'])->name('user.reviews');
Route::post('/users/{id}/enroll', [UserController::class, 'enrollment'])->name('user.enroll');
Route::post('/users/{id}/unenroll', [UserController::class, 'unenrollment'])->name('user.unenroll');
Route::post('/users/photo-change', [UserController::class, 'photoChange'])->name('user.photoChange');
Route::apiResource('/users', UserController::class);

Route::get('/level/{id}/courses', [LevelController::class, 'getCoursesByLevelId'])->name('level.courses');
Route::apiResource('level', LevelController::class);

Route::get('/languages/{id}/courses', [LanguageController::class, 'getCoursesByLanguageId'])->name('languages.courses');
Route::apiResource('languages', LanguageController::class);

Route::apiResource('/reviews', ReviewController::class);
