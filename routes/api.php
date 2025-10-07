<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\MaterialController;
use App\Http\Controllers\API\AssignmentController;
use App\Http\Controllers\API\DiscussionController;
use App\Http\Controllers\API\SubmissionController;

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
    Route::get('/{course}', [CourseController::class, 'show']);
    Route::put('/{course}', [CourseController::class, 'update']);
    Route::delete('/{course}', [CourseController::class, 'destroy']);

    Route::post('/{course}/materials', [MaterialController::class, 'store']);

    Route::get('/{course}/assignments', [AssignmentController::class, 'index']);
    Route::post('/{course}/assignments', [AssignmentController::class, 'store']);
  });

  Route::prefix('courses')->middleware(['role:mahasiswa'])->group(function () {
    Route::post('/{course}/enroll', [CourseController::class, 'enroll']);
  });

  Route::prefix('materials')->middleware(['role:mahasiswa'])->group(function () {
    Route::post('/{material}/materials', [MaterialController::class, 'download']);
  });

  Route::get('/assignments/{assignment}', [AssignmentController::class, 'show'])->middleware('role:dosen');
  Route::put('/assignments/{assignment}', [AssignmentController::class, 'update'])->middleware('role:dosen');
  Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->middleware('role:dosen');

  Route::post('/assignments/{assignment}/submissions', [SubmissionController::class, 'store'])->middleware('role:mahasiswa');
  Route::post('/submissions/{submission}/grade', [SubmissionController::class, 'grade'])->middleware('role:dosen');

  Route::get('/courses/{course}/discussions', [DiscussionController::class, 'index']);
  Route::post('/courses/{course}/discussions', [DiscussionController::class, 'store']);
  Route::post('/discussions/{discussion}/replies', [DiscussionController::class, 'storeReply']);

  Route::get('/reports/courses', [ReportController::class, 'studentsPerCourse']);
  Route::get('/reports/assignments', [ReportController::class, 'assignmentStats']);
  Route::get('/reports/students/{user}', [ReportController::class, 'studentReport']);
});
