<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Community;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = Community::all();

        return response()->json([
            'communities' => $communities,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $community = Community::create([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => \Str::slug($request->name),
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'message' => 'Successfully created community',
            'community' => $community,
        ], 201);
    }
}
