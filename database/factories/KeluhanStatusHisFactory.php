<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class KeluhanStatusHisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'status_keluhan' => $this->faker->randomElement([0, 1, 2]),
            'updated_at' => $this->faker->dateTimeThisYear,
        ];
    }
}
