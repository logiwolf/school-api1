<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\StudentController;
use App\Http\Controllers\Api\V1\ClassroomController;
use App\Http\Middleware\AdminOnly;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', AdminOnly::class])->prefix('v1')->group(function () {
  Route::apiResource('students', StudentController::class);
  Route::apiResource('classrooms', ClassroomController::class);
  Route::post('classrooms/{classroom}/assign', [ClassroomController::class, 'assignStudent']);
});
