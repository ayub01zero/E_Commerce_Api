<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\models\User::factory(),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'notes' => $this->faker->text(200),
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'invoice_no' => $this->faker->unique()->numerify('INV#####'),
            'order_date' => $this->faker->date(),
            'order_month' => $this->faker->monthName(),
            'order_year' => $this->faker->year(),
            'return_date' => $this->faker->optional()->date(),
            'return_order' => $this->faker->boolean(10),
            'status' => $this->faker->randomElement(['pending', 'delivered', 'confirmed']),

        ];
    }
}
