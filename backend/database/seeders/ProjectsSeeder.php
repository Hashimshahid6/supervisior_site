<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Projects::factory(50)->create();
    }
}
