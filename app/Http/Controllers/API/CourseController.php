<?php

namespace App\Http\Controllers\API;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return Course::all();
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
    ]);

    $course = $request->user()->coursesAsLecturer()->create($validatedData);

    return response()->json($course->fresh(), 201);
  }

  /**
   * Display the specified resource.
   */
  public function show(Course $course)
  {
    return $course->load('lecturer');
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Course $course)
  {
    if ($request->user()->id !== $course->lecturer_id) {
      return response()->json(['message' => 'Forbidden'], 403);
    }

    $validatedData = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
    ]);

    $course->update($validatedData);

    return response()->json($course);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request, Course $course)
  {
    if ($request->user()->id !== $course->lecturer_id) {
      return response()->json(['message' => 'Forbidden'], 403);
    }

    $course->delete();

    return response()->json(['message' => 'Course deleted successfully'], 200);
  }

  public function enroll(Request $request, Course $course){
    $user = $request->user();

    $user->coursesAsStudent()->syncWithoutDetaching($course->id);

    return response()->json(['message' => 'Successfully enrolled in course'], 200);
  }
}
