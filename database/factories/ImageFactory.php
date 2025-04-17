<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       $paths = ['test/news1.webp' ,'test/news2.webp','test/news5.webp' ];
      


        return [
            'path' => $this->faker->randomElement($paths),
        ];
    }
}
