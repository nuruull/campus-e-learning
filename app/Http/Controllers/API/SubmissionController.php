<?php

namespace App\Http\Controllers\API;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubmissionController extends Controller
{
  public function store(Request $request, Assignment $assignment)
  {
    $user = $request->user();

    $existingSubmission = $assignment->submissions()->where('student_id', $user->id)->exists();

    if ($existingSubmission) {
      return response()->json(['message' => 'You have already submitted for this assignment.'], 409);
    }

    $request->validate([
      'file_path' => 'required|file|mimes:pdf,doc,docx,zip|max:10240'
    ]);

    $path = $request->file('file_path')->store('submissions', 'public');

    $submission = $assignment->submissions()->create([
      'student_id' => $user->id,
      'file_path' => $path,
    ]);

    return response()->json($submission, 201);
  }

  public function grade(Request $request, Submission $submission)
  {
    if ($request->user()->id !== $submission->assignment->course->lecturer_id) {
      return response()->json(['message' => 'Forbidden'], 403);
    }

    $validatedData = $request->validate([
      'score' => 'required|integer|min:0|max:100',
    ]);

    $submission->update($validatedData);

    return response()->json($submission);
  }
}
