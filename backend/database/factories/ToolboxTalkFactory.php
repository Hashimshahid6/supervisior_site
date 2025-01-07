<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ToolboxTalkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => $this->faker->numberBetween(1, 50),
            'user_id' => $this->faker->numberBetween(1, 30),
            'topic' => $this->faker->sentence,  
            'presented_by' => $this->faker->name,
            'status' => $this->faker->randomElement(['incomplete', 'complete']),
            'created_by' => $this->faker->numberBetween(1, 30),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
