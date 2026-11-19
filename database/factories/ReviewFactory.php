<?php

namespace Database\Factories;

use App\Models\Eatery;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'eatery_id' => Eatery::factory(),
            'user_id' => User::factory(),

            'rating' => fake()->numberBetween(1, 5),

            'body' => fake()->randomElement([
                'Lami kaayo ang pagkaon diri!',
                'Affordable and delicious meals.',
                'Friendly staff and great food.',
                'Nice place for a quick lunch.',
                'I will definitely eat here again.',
                'Good food and reasonable prices.',
            ]),
        ];
    }
}
