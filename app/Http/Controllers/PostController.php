<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลโพสต์พร้อมกับข้อมูลของผู้ใช้, หมวดหมู่, ความคิดเห็น, ไฟล์แนบ
        $posts = Post::with(['user', 'category', 'comments', 'likes', 'attachments'])->get();

        // ดึงข้อมูลหมวดหมู่
        $categories = Category::all();

        // ส่งข้อมูลผ่าน Inertia ไปยัง React คอมโพเนนต์
        return Inertia::render('Sontana/Posts/Index', [
            'posts' => $posts,
            'categories' => $categories
        ]);
    }

    public function create()
    {
        $categories = Category::all(); // ดึงหมวดหมู่จากฐานข้อมูล

        return Inertia::render('Sontana/Posts/create', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        Log::info($request->all());

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // ✅ ตรวจสอบไฟล์รูปภาพก่อนบันทึก
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('postimagenew', 'public');
        }

        DB::transaction(function () use ($validated) {
            Log::info('Insert data into post table:', [
                'user_id' => auth()->id(),
                'title' => $validated['title'],
                'content' => $validated['content'],
                'category_id' => $validated['category_id'],
                'image' => $validated['image'] ?? null,
                'status' => 'active',
            ]);

            DB::table('posts')->insert([
                'user_id' => auth()->id(),
                'title' => $validated['title'],
                'content' => $validated['content'],
                'category_id' => $validated['category_id'],
                'image' => $validated['image'] ?? null,
                'status' => 'active',
            ]);
        });

        return redirect('/sontana/posts')->with('success', 'Post created!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // ตรวจสอบว่าเป็นผู้ใช้ที่โพสต์หรือไม่
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        // ลบไฟล์รูปภาพ (ถ้ามี)
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        // ลบโพสต์
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted!');
    }
}


