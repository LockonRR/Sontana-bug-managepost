<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // สร้างตาราง `cache` สำหรับเก็บข้อมูล cache
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary(); // คอลัมน์เก็บ key เป็น primary key
            $table->mediumText('value'); // คอลัมน์เก็บค่า cache ขนาดกลาง (mediumText) เพื่อเก็บข้อมูลที่ยาวขึ้น
            $table->integer('expiration'); // คอลัมน์เก็บเวลาหมดอายุของ cache (เป็นเลขจำนวนเต็ม)
        });

        // สร้างตาราง `cache_locks` สำหรับเก็บข้อมูลการล็อก cache
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary(); // คอลัมน์เก็บ key ของการล็อกเป็น primary key
            $table->string('owner'); // คอลัมน์เก็บเจ้าของการล็อก (เช่น ID ผู้ใช้หรือข้อมูลอื่น ๆ ที่แสดงถึงเจ้าของ)
            $table->integer('expiration'); // คอลัมน์เก็บเวลาหมดอายุของการล็อก (เป็นเลขจำนวนเต็ม)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ลบตาราง `cache` และ `cache_locks` หากมีการย้อนกลับการอพยพ
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
//ใช้การทำงานร่วมกับคำสั่ง php artisan migrate