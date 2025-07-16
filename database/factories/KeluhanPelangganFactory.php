<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class KeluhanPelangganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'nomor_hp' => $this->faker->numerify('08##########'),
            'status_keluhan' => $this->faker->randomElement(['0', '1', '2']), // 0: Received, 1: In Process, 2: Done
            'keluhan' => $this->faker->sentence,
            'created_at' => $this->faker->dateTimeThisYear, 
        ];
    }
}
