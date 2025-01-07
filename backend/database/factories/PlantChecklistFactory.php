<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlantChecklist>
 */
class PlantChecklistFactory extends Factory
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
            'plant_type' => $this->faker->randomElement(\App\Models\PlantChecklist::$PlantTypes),
            'checklist' => json_encode($this->faker->randomElements(\App\Models\PlantChecklist::$PlantChecklists, 3)),
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
