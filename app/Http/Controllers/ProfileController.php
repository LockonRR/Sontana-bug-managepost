<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest; // ใช้สำหรับ validate ข้อมูลอัปเดตโปรไฟล์
use Illuminate\Contracts\Auth\MustVerifyEmail; // ใช้ตรวจสอบว่าผู้ใช้ต้องยืนยันอีเมลหรือไม่
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ใช้จัดการการล็อกเอาต์
use Illuminate\Support\Facades\Redirect; // ใช้สำหรับ redirect ผู้ใช้
use Inertia\Inertia; // ใช้ในการเรนเดอร์หน้าด้วย Inertia.js
use Inertia\Response;

class ProfileController extends Controller
{

     //แสดงแบบฟอร์มแก้ไขโปรไฟล์ของผู้ใช้

    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            // ตรวจสอบว่าผู้ใช้ต้องยืนยันอีเมลหรือไม่
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            // นำค่าสถานะจาก session  มาใช้
            'status' => session('status'),
        ]);
    }


      //อัปเดตข้อมูลโปรไฟล์ของผู้ใช้
     
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // เติมข้อมูลใหม่ที่ผ่านการตรวจสอบแล้วลงในโมเดลผู้ใช้
        $request->user()->fill($request->validated());

        // หากอีเมลถูกเปลี่ยน ให้รีเซ็ตสถานะการยืนยันอีเมล
        if ($request->user()->isDirty('email')) {//ถ้าอีเมลไม่ตรงกล่องข้อความเป็น null เพื่อบอกว่าไม่ได้ยืนยันอีเมล
            $request->user()->email_verified_at = null;
        }

        // บันทึกข้อมูลใหม่ลงในฐานข้อมูล
        $request->user()->save();

        // Redirect กลับไปยังหน้าแก้ไขโปรไฟล์
        return Redirect::route('profile.edit');
    }

    //ลบบัญชีของผู้ใช้

    public function destroy(Request $request): RedirectResponse
    {
        // ตรวจสอบความถูกต้องของรหัสผ่าน
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        // เก็บข้อมูลผู้ใช้ก่อนทำการลบ
        $user = $request->user();

        // ทำการล็อกเอาต์ผู้ใช้
        Auth::logout();

        // ลบบัญชีผู้ใช้
        $user->delete();

        // ทำการยกเลิก session ปัจจุบัน
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ผู้ใช้ไปยังหน้าหลัก
        return Redirect::to('/');
    }
}
