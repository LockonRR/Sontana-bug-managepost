<?php

// นำเข้า class ที่ใช้สำหรับการแสดงคำพูดสร้างแรงบันดาลใจ
use Illuminate\Foundation\Inspiring;
// นำเข้า class ที่ใช้สำหรับสร้างคำสั่ง Artisan
use Illuminate\Support\Facades\Artisan;

// สร้างคำสั่ง Artisan ใหม่ที่ชื่อว่า "inspire"
Artisan::command('inspire', function () {
    // ดึงคำพูดสร้างแรงบันดาลใจแบบสุ่มและแสดงผลใน terminal
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote') // กำหนดคำอธิบายของคำสั่ง
  ->hourly(); // ตั้งให้คำสั่งนี้ทำงานอัตโนมัติทุกชั่วโมง

  //ใช้กับคำสั่งคำสั่ง php artisan inspire