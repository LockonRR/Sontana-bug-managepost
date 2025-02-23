<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    // ดึงข้อมูลผู้ใช้ทั้งหมดและส่งไปยัง Inertia
    public function index()
    {
        $users = User::withCount([
            'posts',
            'reports as reports_sent_count'
        ])->get();

        return Inertia::render('Admin/Usermanage', [
            'users' => $users
        ]);
    }
    // ดึงข้อมูลผู้ใช้ตาม ID
    public function show($id)
    {
        $user = User::withCount(['Post', 'Report'])->find($id);

        if (!$user) {
            return redirect()->back()->withErrors(['message' => 'User not found']);
        }

        return Inertia::render('Admin/UserDetail', [
            'user' => $user
        ]);
    }

    // เพิ่มผู้ใช้ใหม่
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    // อัปเดตข้อมูลผู้ใช้
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->withErrors(['message' => 'User not found']);
        }

        $user->update($request->only(['name', 'email']));

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    // ลบผู้ใช้
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->withErrors(['message' => 'User not found']);
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
