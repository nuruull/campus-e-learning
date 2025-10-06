<?php

namespace App\Http\Controllers\API;

use App\Models\Course;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
  public function store(Request $request, Course $course)
  {
    $request->validate([
      'title' => 'required|string|max:255',
      'file_path' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:10240',
    ]);

    if ($request->user()->id !== $course->lecturer_id) {
      return response()->json(['message' => 'Forbidden'], 403);
    }

    $path = $request->file('file_path')->store('course_materials', 'public');

    $material = $course->materials()->create([
      'title' => $request->input('title'),
      'file_path' => $path,
    ]);

    return response()->json($material, 201);
  }

  public function download(Material $material)
  {
    return Storage::disk('public')->download($material->file_path, $material->title);
  }
}
