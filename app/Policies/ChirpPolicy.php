<?php

namespace App\Policies;

use App\Models\Chirp; // Import โมเดล Chirp สำหรับใช้ในการตรวจสอบ
use App\Models\User;  // Import โมเดล User สำหรับตรวจสอบผู้ใช้งาน
use Illuminate\Auth\Access\Response; // Import Response (ถ้าต้องการตอบกลับข้อความ)

class ChirpPolicy
{
    /**
     * กำหนดว่าผู้ใช้สามารถดูรายการของ Chirps ได้หรือไม่
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        // ค่าเริ่มต้น: ไม่อนุญาตให้ดูรายการ Chirps
        return false;
    }

    /**
     * กำหนดว่าผู้ใช้สามารถดู Chirp ใดๆ ได้หรือไม่
     * @param User $user
     * @param Chirp $chirp
     * @return bool
     */
    public function view(User $user, Chirp $chirp): bool
    {
        // ค่าเริ่มต้น: ไม่อนุญาตให้ดู Chirp ใดๆ
        return false;
    }

    /**
     * กำหนดว่าผู้ใช้สามารถสร้าง Chirps ได้หรือไม่
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        // ค่าเริ่มต้น: ไม่อนุญาตให้สร้าง Chirps
        return false;
    }

    /**
     * กำหนดว่าผู้ใช้สามารถแก้ไข Chirp ได้หรือไม่
     * @param User $user
     * @param Chirp $chirp
     * @return bool
     */
    public function update(User $user, Chirp $chirp): bool
    {
        // อนุญาตให้ผู้ใช้แก้ไข Chirp เฉพาะของตัวเองเท่านั้น
        return $chirp->user()->is($user);
    }

    /**
     * กำหนดว่าผู้ใช้สามารถลบ Chirp ได้หรือไม่
     * @param User $user
     * @param Chirp $chirp
     * @return bool
     */
    public function delete(User $user, Chirp $chirp): bool
    {
        // ใช้ logic เดียวกับการอัปเดต: ผู้ใช้สามารถลบ Chirp ของตัวเองได้เท่านั้น
        return $this->update($user, $chirp);
    }

    /**
     * กำหนดว่าผู้ใช้สามารถกู้คืน Chirp ได้หรือไม่
     * @param User $user
     * @param Chirp $chirp
     * @return bool
     */
    public function restore(User $user, Chirp $chirp): bool
    {
        // ค่าเริ่มต้น: ไม่อนุญาตให้กู้คืน Chirp
        return false;
    }

    /**
     * กำหนดว่าผู้ใช้สามารถลบ Chirp แบบถาวรได้หรือไม่
     * @param User $user
     * @param Chirp $chirp
     * @return bool
     */
    public function forceDelete(User $user, Chirp $chirp): bool
    {
        // ค่าเริ่มต้น: ไม่อนุญาตให้ลบ Chirp แบบถาวร
        return false;
    }
}
