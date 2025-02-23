<?php
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use Inertia\Inertia;
use App\Models\Post;
use App\Models\User;
use App\Models\Report;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Profile;
use App\Models\Role;
use App\Models\Category;



// เส้นทางสำหรับแดชบอร์ดที่ต้องการการยืนยันตัวตนและอีเมล

// กลุ่มเส้นทางที่ต้องการการยืนยันตัวตน
Route::middleware('auth')->group(function () {
    // เส้นทางสำหรับการแก้ไขข้อมูลโปรไฟล์
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // เส้นทางสำหรับการอัพเดทข้อมูลโปรไฟล์
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // เส้นทางสำหรับการลบโปรไฟล์
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    return redirect()->route('post.index');
});
Route::get('/sontana/posts', [PostController::class, 'index'])->name('post.index');

Route::middleware('auth')->group(function () {
    Route::get('/sontana/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/sontana/posts', [PostController::class, 'store'])->name('post.store');
    Route::get('/sontana/posts/{id}', [PostController::class, 'show'])->name('post.show');
    Route::get('/sontana/posts/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/sontana/posts/{id}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/sontana/posts/{id}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::post('/posts/{id}/comment', [CommentController::class, 'store'])->name('comment.store');

});

// Dashboard - Fetching Statistics
Route::get('/admindb', function () {
    $user = auth()->user();

    // ตรวจสอบว่า role เป็น 'admin' หรือไม่
    if ($user && $user->role === 'admin') {
        // ดึงข้อมูลและแสดงหน้า Admin Dashboard
        $totalUsers = User::count();
        $totalPosts = Post::count();
        $totalReports = Report::count();
        $usersToday = User::withCount('posts')
            ->whereDate('created_at', now()->toDateString())
            ->get(['id', 'name', 'email']);

        return Inertia::render('Admin/Dashboard', [
            'totalUsers' => $totalUsers,
            'totalPosts' => $totalPosts,
            'totalReports' => $totalReports,
            'usersToday' => $usersToday,
        ]);
    }

    // ถ้า role ไม่ใช่ 'admin' ให้รีไดเร็กต์ไปหน้าอื่น
    return redirect()->route('login')->with('error', 'You do not have access to this page');
});

// User Management - Fetching Users from Database
Route::get('/usermanage', [UserController::class, 'index'])->name('Admin/Usermanage');

// Static Views (No Data Fetching Needed)
Route::get('/manageposts', function () {
    return Inertia::render('Admin/Manageposts');
});

Route::get('/commentreports', function () {
    return Inertia::render('Admin/Comment_Reports');



});




require __DIR__.'/auth.php';
