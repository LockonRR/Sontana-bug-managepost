<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // สร้างผู้ใช้จำลอง 50 คน
        User::factory()->count(50)->create();
        
        // ถ้าต้องการผู้ใช้ที่ยังไม่ได้ยืนยันอีเมล
        User::factory()->unverified()->count(10)->create();
    }
}
