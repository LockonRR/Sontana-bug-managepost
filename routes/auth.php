<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// กำหนดเส้นทางที่สามารถเข้าถึงได้เฉพาะผู้ที่ไม่ได้เข้าสู่ระบบ (guest)
Route::middleware('guest')->group(function () {
    // เส้นทางสำหรับแสดงฟอร์มการสมัครสมาชิก
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    // เส้นทางสำหรับการส่งข้อมูลฟอร์มการสมัครสมาชิก
    Route::post('register', [RegisteredUserController::class, 'store']);

    // เส้นทางสำหรับแสดงฟอร์มการเข้าสู่ระบบ
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // เส้นทางสำหรับการส่งข้อมูลฟอร์มการเข้าสู่ระบบ
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // เส้นทางสำหรับแสดงฟอร์มการขอรีเซ็ตรหัสผ่าน
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    // เส้นทางสำหรับการส่งคำขอรีเซ็ตรหัสผ่าน
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // เส้นทางสำหรับแสดงฟอร์มการรีเซ็ตรหัสผ่าน โดยใช้โทเค็น
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    // เส้นทางสำหรับการส่งข้อมูลฟอร์มการรีเซ็ตรหัสผ่าน
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// กำหนดเส้นทางที่สามารถเข้าถึงได้เฉพาะผู้ที่เข้าสู่ระบบ (auth)
Route::middleware('auth')->group(function () {
    // เส้นทางสำหรับการแสดงคำแนะนำให้ผู้ใช้ยืนยันอีเมล
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    // เส้นทางสำหรับการยืนยันอีเมล โดยมีการตรวจสอบลายเซ็นและการควบคุมอัตราการเข้าถึง
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // เส้นทางสำหรับการส่งคำขอยืนยันอีเมลใหม่ (มีการควบคุมอัตราการเข้าถึง)
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // เส้นทางสำหรับแสดงฟอร์มการยืนยันรหัสผ่าน
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    // เส้นทางสำหรับการส่งข้อมูลฟอร์มการยืนยันรหัสผ่าน
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // เส้นทางสำหรับการอัพเดตรหัสผ่านของผู้ใช้
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // เส้นทางสำหรับการออกจากระบบของผู้ใช้
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
