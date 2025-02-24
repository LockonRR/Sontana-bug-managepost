<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'ข่าวสารและเหตุการณ์ปัจจุบัน',
            'เทคโนโลยีและแกดเจ็ต',
            'เกมและอีสปอร์ต',
            'หนังและซีรีส์',
            'ดนตรีและศิลปะ',
            'อาหารและสุขภาพ',
            'กีฬาและฟิตเนส',
            'ท่องเที่ยวและธรรมชาติ',
            'การศึกษาและพัฒนาตนเอง',
            'ธุรกิจและการเงิน',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
