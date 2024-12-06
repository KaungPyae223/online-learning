<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\LessonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/course/update-photo',[CourseController::class,'updateImage']);
Route::post('/lesson/update-video',[LessonController::class,'updateLessonVideo']);

Route::apiResource('/category',CategoryController::class);
Route::apiResource('/course',CourseController::class);
Route::apiResource('/curricula',CurriculumController::class);
Route::apiResource('/lesson',LessonController::class);
