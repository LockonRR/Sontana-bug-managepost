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
        // สร้างตาราง `users` เพื่อเก็บข้อมูลผู้ใช้
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // คอลัมน์ primary key สำหรับ `id` ผู้ใช้
            $table->string('name'); // คอลัมน์เก็บชื่อผู้ใช้
            $table->string('email')->unique(); // คอลัมน์เก็บอีเมลที่ไม่ซ้ำ
            $table->timestamp('email_verified_at')->nullable(); // คอลัมน์เวลาการยืนยันอีเมล (อาจเป็น NULL)
            $table->string('password'); // คอลัมน์เก็บรหัสผ่านที่แฮชแล้ว
            $table->enum('role', ['admin', 'moderator', 'user'])->default('user');
            $table->rememberToken(); // คอลัมน์สำหรับ token ในการจำการเข้าสู่ระบบ (Remember Me)
            $table->timestamps(); // คอลัมน์ `created_at` และ `updated_at` โดยอัตโนมัติ
        });

        
        // สร้างตาราง `password_reset_tokens` เพื่อเก็บข้อมูลการตั้งรหัสผ่านใหม่
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // คอลัมน์อีเมลเป็น primary key
            $table->string('token'); // คอลัมน์เก็บ token สำหรับการรีเซ็ตรหัสผ่าน
            $table->timestamp('created_at')->nullable(); // คอลัมน์เวลาการสร้าง token (อาจเป็น NULL)
        });

        // สร้างตาราง `sessions` เพื่อเก็บข้อมูลการเข้าสู่ระบบของผู้ใช้
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // คอลัมน์ `id` ของ session เป็น primary key
            $table->foreignId('user_id')->nullable()->index(); // คอลัมน์ foreign key ที่ชี้ไปที่ผู้ใช้ (อาจเป็น NULL)
            $table->string('ip_address', 45)->nullable(); // คอลัมน์เก็บที่อยู่ IP ของผู้ใช้
            $table->text('user_agent')->nullable(); // คอลัมน์เก็บ user agent ของการเชื่อมต่อ
            $table->longText('payload'); // คอลัมน์เก็บข้อมูล payload ของ session
            $table->integer('last_activity')->index(); // คอลัมน์เก็บเวลาที่การกระทำสุดท้ายของ session เกิดขึ้น (index เพื่อการค้นหาเร็ว)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ลบตารางทั้งหมดหากการย้อนกลับการอพยพเกิดขึ้น
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
//ใช้การทำงานร่วมกับคำสั่ง php artisan migrate
