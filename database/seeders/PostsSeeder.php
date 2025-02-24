<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostsSeeder extends Seeder
{
    public function run(): void
    {
        Post::factory()->count(30)->create(); // สร้าง 100 โพสต์
    }
}
