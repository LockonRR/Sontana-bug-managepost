<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Like;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class LikeFactory extends Factory
{
    protected $model = Like::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'post_id' => $this->faker->optional()->randomElement(Post::pluck('id')->toArray()),
            'comment_id' => $this->faker->optional()->randomElement(Comment::pluck('id')->toArray()),
            'created_at' => now(),
        ];
    }
}
