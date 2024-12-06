<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\InstructorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('instructors',InstructorController::class);


Route::apiResource('blog',BlogController::class);

Route::apiResource('faq',FAQController::class);
