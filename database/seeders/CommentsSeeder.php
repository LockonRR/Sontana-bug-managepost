<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentsSeeder extends Seeder
{
    public function run(): void
    {
        Comment::factory()->count(200)->create();
    }
}
