<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Products;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    protected $model = Products::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => $this->factoryForModel(\App\Models\Category::class),
            'image_id' => $this->faker->randomNumber(),
            'product_name' => $this->faker->words(3, true),
            'product_code' => $this->faker->unique()->ean8,
            'product_qty' => $this->faker->numberBetween(1, 100),
            'product_tags' => $this->faker->words(5, true),
            'weight' => $this->faker->randomFloat(2, 0.1, 10),
            'selling_price' => $this->faker->randomFloat(2, 10, 100),
            'discount_price' => $this->faker->optional()->randomFloat(2, 5, 50),
            'short_des' => $this->faker->sentence(),
            'long_des' => $this->faker->paragraph(),
            'show_slider' => $this->faker->optional()->boolean,
            'week_deals' => $this->faker->optional()->boolean,
            'special_offer' => $this->faker->optional()->boolean,
            'new_products' => $this->faker->optional()->boolean,
            'discount_products' => $this->faker->optional()->boolean,
            'status' => $this->faker->boolean,

        ];
    }
}
