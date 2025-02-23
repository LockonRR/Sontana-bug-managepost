<?php

namespace Database\Seeders;
use Database\Factories\CategoryFactory; // เพิ่มบรรทัดนี้
use App\Models\Category;  // เพิ่มบรรทัดนี้ ถ้าหากยังไม่มี
use Database\Factories\PostsFactory; // เพิ่มบรรทัดนี้
use App\Models\Post;
use App\Models\User; // ใช้โมเดล User เพื่อเข้าถึงและสร้างข้อมูลผู้ใช้
// use Illuminate\Database\Console\Seeds\WithoutModelEvents; // ใช้สำหรับปิดการจับเหตุการณ์โมเดล (ไม่จำเป็นในที่นี้)
use Illuminate\Database\Seeder; // ใช้สำหรับสร้าง class Seeder ใน Laravel

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * เมธอดนี้ใช้สำหรับทำการ seed ข้อมูลเริ่มต้นลงในฐานข้อมูล.
     */
    public function run(): void
    {
        // สร้างผู้ใช้ 10 รายการโดยใช้ factory (ถูกคอมเมนต์ไว้)
        // User::factory(10)->create();

        // สร้างผู้ใช้หนึ่งรายด้วยข้อมูลที่กำหนดเอง
        User::factory()->create([
            'name' => 'Test User', // กำหนดชื่อผู้ใช้เป็น "Test User"
            'email' => 'test@example.com', // กำหนดอีเมลของผู้ใช้
        ]);
    }
}
