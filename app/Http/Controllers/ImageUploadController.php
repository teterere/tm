<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'image'   => 'required|image|max:10240',
            'context' => 'required|in:comment,task,avatar',
        ]);

        $folder = match ($request->get('context')) {
            'comment' => 'uploads/comments',
            'task' => 'uploads/tasks',
            'avatar' => 'uploads/avatars'
        };

        $path = $request->file('image')->store($folder, 'public');

        return response()->json([
            'url' => Storage::url($path)
        ]);
    }
}
