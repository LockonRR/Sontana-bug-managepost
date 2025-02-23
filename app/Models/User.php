<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany; // ใช้กำหนดความสัมพันธ์แบบ HasMany
use Illuminate\Database\Eloquent\Factories\HasFactory; // ใช้สำหรับสร้าง factory ในการทดสอบ
use Illuminate\Foundation\Auth\User as Authenticatable; // ใช้สร้าง User Model ที่รองรับการ Authentication
use Illuminate\Notifications\Notifiable; // ใช้สำหรับส่งการแจ้งเตือน (Notifications)
use Laravel\Sanctum\HasApiTokens; // เพิ่มการใช้งาน HasApiTokens เพื่อใช้ createToken()

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // เพิ่ม HasApiTokens ที่นี่

    protected $fillable = [
        'name', 
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
