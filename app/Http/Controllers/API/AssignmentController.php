<?php

namespace App\Http\Controllers\API;

use App\Models\Course;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewAssignmentNotification;

class AssignmentController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Course $course)
  {
    return $course->assignments;
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request, Course $course)
  {
    if ($request->user()->id !== $course->lecturer_id) {
      return response()->json(['message' => 'Forbidden'], 403);
    }

    $validatedData = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'nullable|string',
      'deadline' => 'required|date',
    ]);

    $assignment = $course->assignments()->create($validatedData);

    $students = $course->students;

    foreach ($students as $student) {
      Mail::to($student->email)->queue(new NewAssignmentNotification($assignment));
    }

    return response()->json($assignment, 201);
  }

  /**
   * Display the specified resource.
   */
  public function show(Assignment $assignment)
  {
    return $assignment;
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Assignment $assignment)
  {
    if (!$assignment->course || $request->user()->id !== $assignment->course->lecturer_id) {
      return response()->json(['message' => 'Forbidden'], 403);
    }

    $validatedData = $request->validate([
      'title' => 'sometimes|required|string|max:25',
      'description' => 'sometimes|required|string',
      'deadline' => 'sometimes|required|date',
    ]);

    $assignment->update($validatedData);

    return response()->json($assignment);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request, Assignment $assignment)
  {
    if ($request->user()->id !== $assignment->course->lecturer_id) {
      return response()->json(['message' => 'Forbidden'], 403);
    }

    $assignment->delete();

    return response()->json(['message' => 'Assignment deleted successfully'], 200);
  }
}
