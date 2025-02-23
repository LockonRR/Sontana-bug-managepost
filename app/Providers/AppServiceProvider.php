<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite; // Import Vite สำหรับจัดการ Assets
use Illuminate\Support\ServiceProvider; // ใช้สร้าง Service Provider

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * 
     * ใช้สำหรับลงทะเบียน Service หรือ Binding ใด ๆ ที่ต้องการในแอปพลิเคชัน
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     * 
     * ใช้สำหรับการตั้งค่าหรือกระทำใด ๆ ที่ต้องการในขณะบูทแอปพลิเคชัน
     */
    public function boot(): void
    {
        // ตั้งค่า Vite ให้ใช้ prefetch สำหรับโหลดไฟล์ล่วงหน้า
        Vite::prefetch(concurrency: 3); // กำหนด concurrency ให้โหลดได้พร้อมกัน 3 ไฟล์
    }
}
