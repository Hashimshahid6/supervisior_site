<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class VehicleChecklistFactory extends Factory
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
            'vehicle_data' => json_encode([
                'Vehicle Registration' => $this->faker->word,
                'Date' => $this->faker->date,
                'Driver Name' => $this->faker->name,
                'Odometer (km/miles) reading' => $this->faker->numberBetween(1000, 100000)
            ]),
            'checklist' => json_encode($this->faker->randomElements(\App\Models\VehicleChecklist::$VehicleItems, 3)),
            'reports' => json_encode([
                'defect' => $this->faker->sentence,
                'date_reported' => $this->faker->date,
                'useable' => $this->faker->boolean,
                'reported_to' => $this->faker->name,
                'operator' => $this->faker->name
            ]),
            'status' => $this->faker->randomElement(['incomplete', 'complete']),
            'created_by' => $this->faker->numberBetween(1, 30),
            'updated_by' => $this->faker->numberBetween(1, 30),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
