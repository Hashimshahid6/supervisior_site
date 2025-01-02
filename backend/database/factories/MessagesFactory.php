<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Messages>
 */
class MessagesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'projects_id' => $this->faker->numberBetween(1, 55),
            'user_id' => $this->faker->numberBetween(1, 55),
            'message' => $this->faker->sentence,
            'created_by' => $this->faker->numberBetween(1, 55),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
