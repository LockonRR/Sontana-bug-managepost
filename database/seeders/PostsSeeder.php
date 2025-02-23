<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Post;

class PostsSeeder extends Seeder
{
    public function run(): void
    {
        // สร้างโพสต์จำลอง 100 โพสต์
        Post::factory()->count(100)->create();
    }
}
