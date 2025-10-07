<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
  public function studentsPerCourse()
  {
    $report = Course::withCount('students')->get();
    return response()->json($report);
  }

  public function assignmentStats(Request $request)
  {
    $user = $request->user();

    $query = Submission::query();

    if ($user->hasRole('mahasiswa')) {
      $query->where('student_id', $user->id);
    } elseif ($user->hasRole('dosen')) {
      $query->whereHas('assignment.course', function ($q) use ($user) {
        $q->where('lecturer_id', $user->id);
      });
    }
    
    $gradedCount = (clone $query)->whereNotNull('score')->count();
    $ungradedCount = (clone $query)->whereNull('score')->count();

    return response()->json([
      'graded_submissions' => $gradedCount,
      'ungraded_submissions' => $ungradedCount,
      'total_submissions' => $gradedCount + $ungradedCount,
    ]);
  }

  public function studentReport(Request $request, User $user)
  {
    $loggedInUser = $request->user();

    if ($loggedInUser->hasRole('mahasiswa') && $loggedInUser->id !== $user->id) {
      return response()->json(['message' => 'Forbidden: You can only view your own report.'], 403);
    }

    $user->load('submissions.assignment');
    $averageScore = $user->submissions()->avg('score');
    $user->average_score = round($averageScore, 2);

    return response()->json($user);
  }
}
