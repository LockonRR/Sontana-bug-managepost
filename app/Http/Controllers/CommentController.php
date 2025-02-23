<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $post = Post::findOrFail($id);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
            'status' => 'active',
        ]);

        return Redirect::route('post.show', $post->id)->with('success', 'Comment added!');
    }

    public function show($id)
    {
        $post = Post::with('comments.user')->findOrFail($id);

        return Inertia::render('PostDetail', [
            'post' => $post,
            'comments' => $post->comments ?? [],
        ]);
    }

}
