<?php

namespace Database\Factories;

use App\Models\Eatery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Dish>
 */
class DishFactory extends Factory
{
    public function definition(): array
    {
        return [
            'eatery_id' => Eatery::factory(),

            'name' => fake()->randomElement([
                'Chicken Adobo',
                'Pork Sinigang',
                'Beef Caldereta',
                'Grilled Bangus',
                'Pancit Canton',
                'Fried Chicken',
                'Vegetable Lumpia',
                'Ginataang Gulay',
                'Lechon Kawali',
                'Chicken Tinola',
            ]),

            'price' => fake()->randomFloat(2, 50, 350),
            'is_bestseller' => fake()->boolean(30),
        ];
    }
}
