<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory; // ใช้สำหรับสร้าง Factory
use Illuminate\Support\Facades\Hash; // ใช้สำหรับแฮชรหัสผ่าน
use Illuminate\Support\Str; // ใช้สำหรับสร้าง string แบบสุ่ม

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 * Factory สำหรับสร้างข้อมูลจำลองของโมเดล User
 */
class UserFactory extends Factory
{
    /**
     * รหัสผ่านปัจจุบันที่ใช้ใน Factory
     * ใช้ `static` เพื่อแชร์ตัวแปรระหว่างการเรียกใช้งานหลายครั้ง
     */
    protected static ?string $password;

    /**
     * กำหนดค่าดีฟอลต์สำหรับโมเดล
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // ชื่อผู้ใช้ (สุ่มจาก fake)
            'name' => fake()->name(),

            'role' => $this->faker->randomElement(['admin', 'moderator', 'user']),
            
            // อีเมล (สุ่มและตรวจสอบให้ไม่ซ้ำ)
            'email' => fake()->unique()->safeEmail(),

            // เวลาที่อีเมลยืนยัน (ตั้งเป็นเวลาปัจจุบัน)
            'email_verified_at' => now(),

            // รหัสผ่าน (ถ้าไม่ได้ตั้งค่า จะสร้างใหม่ครั้งเดียว)
            'password' => static::$password ??= Hash::make('password'),

            // สุ่ม token สำหรับ Remember Me
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * กำหนดสถานะว่าอีเมลไม่ได้รับการยืนยัน
     * เพิ่มสถานะ `unverified` สำหรับอีเมล
     */
    public function unverified(): static
    {
        // ตั้งค่า `email_verified_at` เป็น null
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
