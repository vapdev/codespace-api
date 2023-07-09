<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function postsByCommunity($community_id)
    {
        $posts = Post::where('community_id', $community_id)
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->get();

        return response()->json([
            'posts' => $posts,
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'community_id' => 'nullable|exists:communities,id',
            'is_published' => 'required|boolean',
            'published_at' => 'nullable|date',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'community_id' => $request->community_id,
            'is_published' => $request->is_published,
            'published_at' => $request->published_at,
            'slug' => \Str::slug($request->title),
            'user_id' => auth()->user()->id,
        ]);

        return response()->json([
            'message' => 'Successfully created post',
            'post' => $post,
        ], 201);
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== auth()->user()->id) {
            return response()->json([
                'message' => 'You are not authorized to delete this post',
            ], 403);
        }

        $post->delete();

        return response()->json([
            'message' => 'Successfully deleted post',
        ]);
    }
}
