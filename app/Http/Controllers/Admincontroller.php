<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class Admincontroller extends Controller
{
    public function admindashboard()
    {
        return Inertia::render('Admin/Dashboard');
    }

    public function manageposts()
    {
        return Inertia::render('Admin/Manageposts');
    }

    public function reports()
    {
        return Inertia::render('Admin/Reports');
    }

    public function usermanage()
    {

        return Inertia::render('Admin/Usermanage');
    }

    // ภายในฟังก์ชันใน AdminController
    public function showAdminPage()
    {
        // ดึงข้อมูลผู้ใช้ที่ล็อกอิน
        $user = auth()->user();

        // ตรวจสอบว่า role ของผู้ใช้ตรงกับ 'admin' หรือไม่
        if ($user && $user->role === 'admin') {
            // ถ้ามีสิทธิ์ให้เข้าถึงหน้า admin
            return view('admin.dashboard');
        }

        // ถ้าไม่มีสิทธิ์ให้ไปที่หน้าอื่น (เช่น home)
        return redirect()->route('home')->with('error', 'You do not have access to this page');
    }

}
