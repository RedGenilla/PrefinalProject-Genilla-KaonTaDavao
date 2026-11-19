<?php

namespace Database\Factories;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Eatery>
 */
class EateryFactory extends Factory
{
    public function definition(): array
    {
        // Unique names prevent duplicate eatery records.
        $name = 'Carinderia ' . fake()->unique()->company();

        return [
            'district_id' => District::inRandomOrder()->firstOrFail()->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'address' => fake()->streetAddress() . ', Davao City',
            'price_range' => fake()->randomElement([
                'budget', 'mid', 'splurge'
            ]),
            'specialty' => fake()->randomElement([
                'Tinolang Manok',
                'Kinilaw na Tuna',
                'Adobong Manok',
                'Sinigang',
                'Pork Humba',
            ]),
            'is_open' => true,
        ];
    }

    // Factory state for closed eateries.
    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_open' => false,
        ]);
    }
}
