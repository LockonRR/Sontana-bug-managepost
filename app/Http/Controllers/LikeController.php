<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;

class LikeController extends Controller
{
    public function store($id)
    {
        $user = auth()->user();

        // ค้นหาโพสต์
        $post = Post::findOrFail($id);

        // ตรวจสอบว่าผู้ใช้เคยกดไลก์หรือยัง
        $like = Like::where('post_id', $post->id)
                    ->where('user_id', $user->id)
                    ->first();

        if ($like) {
            // ถ้ามีไลก์อยู่แล้ว ให้ยกเลิกไลก์
            $like->delete();
            return response()->json(['message' => 'Unliked post', 'likes_count' => $post->likes()->count()], 200);
        }

        // ถ้ายังไม่เคยไลก์ ให้เพิ่มไลก์ใหม่
        Like::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        return response()->json(['message' => 'Liked post', 'likes_count' => $post->likes()->count()], 201);
    }
}
