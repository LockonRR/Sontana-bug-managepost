<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // รับค่า category_id จาก query string
        $category_id = $request->input('category_id');

        // ตรวจสอบว่าเป็นการเรียก API หรือไม่
        if ($request->expectsJson()) {
            // ถ้าเป็นการเรียกแบบ API ให้คืนข้อมูลในรูปแบบ JSON
            $posts = Post::with(['user', 'category', 'comments', 'likes', 'attachments'])
            ->when($category_id, function ($query) use ($category_id) {
                return $query->where('category_id', $category_id);
            })
                ->get();

            return response()->json($posts);
        }

        // ถ้าเป็นการเรียกจาก Inertia ให้ส่งไปยัง React component
        $posts = Post::with(['user', 'category', 'comments', 'likes', 'attachments'])
        ->when($category_id, function ($query) use ($category_id) {
            return $query->where('category_id', $category_id);
        })
            ->get();

        $categories = Category::all();
        $selectedCategory = $category_id ? Category::find($category_id) : null;

        return Inertia::render('Sontana/Posts/Index', [
            'posts' => $posts,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // ✅ ตรวจสอบไฟล์รูปภาพ
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


    public function show($id)
    {
        // ดึงข้อมูลโพสต์พร้อมความสัมพันธ์
        $post = Post::with(['user', 'category', 'comments.user', 'likes', 'attachments'])
            ->findOrFail($id);

        // ✅ ดึงหมวดหมู่ทั้งหมด
        $categories = Category::all();

        return Inertia::render('Sontana/Posts/Postid', [
            'post' => $post,
            'categories' => $categories, // ✅ ต้องส่ง categories ไป
        ]);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $post = Post::with('comments')->findOrFail($id);
            $post->comments()->delete(); // ลบคอมเมนต์ของโพสต์
            $post->delete(); // ลบโพสต์
        });

        return redirect()->route('post.index')->with('success', 'Post deleted successfully!');
    }
}
