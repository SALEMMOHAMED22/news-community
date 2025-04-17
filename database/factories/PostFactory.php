<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
     //   $date = fake()->date('y-m-d h-m-s');
        return [
            'title'=>fake()->sentence(3),
            'desc'=>fake()->paragraph(5),
            'status'=>fake()->randomElement([1,0]),
            'comment_able'=>fake()->randomElement([1,0]),
            'num_of_views'=>rand(0,100),
            'user_id'=>User::inRandomorder()->first()->id,
            'category_id'=>Category::inRandomorder()->first()->id,
            'created_at'=>now(),
            'updated_at'=>now(),
        ];
    }
}
