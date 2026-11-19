<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            'Suki ni Genilla',
            'Budget Meal',
            'Halal',
            'Open 24 Hours',
            'Aircon',
            'Free Wi-Fi',
        ];

        // Save the six eatery features.
        foreach ($features as $name) {
            Feature::create([
                'name' => $name,
            ]);
        }
    }
}
