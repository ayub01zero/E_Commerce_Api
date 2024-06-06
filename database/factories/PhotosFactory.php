<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photos>
 */
class PhotosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           
            'imageable_id' => $this->faker->numberBetween(1, 5),
            'imageable_type' => $this->faker->randomElement(['App\Models\Products', 'App\Models\Category']),
            'url' => $this->faker->imageUrl(),

        ];
    }
}
