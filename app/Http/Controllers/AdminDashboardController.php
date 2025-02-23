<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Report;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
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
            'usersToday' => $usersToday
        ]);
    }
}
