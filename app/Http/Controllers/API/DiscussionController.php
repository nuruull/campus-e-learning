<?php

namespace App\Http\Controllers\API;

use App\Models\Course;
use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Events\NewReplyPosted;
use App\Http\Controllers\Controller;

class DiscussionController extends Controller
{
    public function index(Course $course)
    {
        $discussions = $course->discussions()->with('user', 'replies.user')->latest()->get();

        return response()->json($discussions);
    }

    public function store(Request $request, Course $course)
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
        ]);

        $discussion = $course->discussions()->create([
            'user_id' => $request->user()->id,
            'content' => $validatedData['content'],
        ]);

        $discussion->load('user');

        return response()->json($discussion, 201);
    }

    public function storeReply(Request $request, Discussion $discussion)
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
        ]);

        $reply = $discussion->replies()->create([
            'user_id' => $request->user()->id,
            'content' => $validatedData['content'],
        ]);

        $reply->load('user');

        broadcast(new NewReplyPosted($reply->fresh()))->toOthers();

        return response()->json($reply, 201);
    }
}
