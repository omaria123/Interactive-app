<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;

class PostApiController extends Controller
{
    public function index()
    {
        $posts = Post::published()->with(['user', 'tags', 'comments'])->latest()->get();

        return PostResource::collection($posts);
    }

    public function show($id)
    {
        $post = Post::with(['user', 'tags', 'comments'])->findOrFail($id);

        return new PostResource($post);
    }
}