<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(3, true),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'views' => $this->faker->numberBetween(0, 500),
            'status' => $this->faker->randomElement(['active', 'locked', 'deleted']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
