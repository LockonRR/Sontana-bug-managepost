<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Report;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        return [
            'reporter_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'post_id' => $this->faker->optional()->randomElement(Post::pluck('id')->toArray()),
            'comment_id' => $this->faker->optional()->randomElement(Comment::pluck('id')->toArray()),
            'reason' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['pending', 'reviewed', 'dismissed']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
