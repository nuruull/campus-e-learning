<?php

use App\Http\Controllers\API\MaterialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CourseController;

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

Route::middleware('auth:sanctum')->group(function () {
  Route::prefix('courses')->middleware(['role:dosen'])->group(function () {
    Route::get('/', [CourseController::class, 'index']);
    Route::post('/', [CourseController::class, 'store']);
    Route::put('/{course}', [CourseController::class, 'update']);
    Route::delete('/{course}', [CourseController::class, 'destroy']);

    Route::post('/{course}/materials', [MaterialController::class, 'store']);
  });

  Route::prefix('courses')->middleware(['role:mahasiswa'])->group(function () {
    Route::post('/{course}/enroll', [CourseController::class, 'enroll']);
  });

  Route::prefix('materials')->middleware(['role:mahasiswa'])->group(function () {
    Route::post('/{material}/materials', [MaterialController::class, 'download']);
  });
});
