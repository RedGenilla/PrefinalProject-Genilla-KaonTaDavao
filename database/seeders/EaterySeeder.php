<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Dish;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\Permit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EaterySeeder extends Seeder
{
    public function run(): void
    {
        // Find Poblacion for our personalized eatery.
        $poblacion = District::where('name', 'Poblacion')
            ->firstOrFail();

        $name = 'Carinderia ni Genilla';

        // Create this eatery manually, not through a factory.
        $eatery = Eatery::create([
            'district_id' => $poblacion->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'address' => 'San Pedro St., Poblacion, Davao City',
            'price_range' => 'budget',
            'specialty' => 'Tinolang Manok',
            'is_open' => true,
        ]);

        // Create its business permit through the relationship.
        $eatery->permit()->create([
            'permit_no' => 'DVO-2026-0915',
            'expires_on' => '2027-09-15',
        ]);

        // Attach exactly two features using sync().
        $featureIds = Feature::whereIn('name', [
            'Suki ni Genilla',
            'Budget Meal',
        ])->pluck('id')->all();

        $eatery->features()->sync($featureIds);

        // Add exactly three dishes with required prices.
        $eatery->dishes()->createMany([
            [
                'name' => 'Tinolang Manok',
                'price' => 85.00,
                'is_bestseller' => true,
            ],
            [
                'name' => 'Kinilaw na Tuna',
                'price' => 120.00,
                'is_bestseller' => false,
            ],
            [
                'name' => 'Durian Shake',
                'price' => 75.00,
                'is_bestseller' => false,
            ],
        ]);

        // Create 11 open factory eateries.
        $openEateries = Eatery::factory()
            ->count(11)
            ->create();

        // Create exactly 3 closed factory eateries.
        $closedEateries = Eatery::factory()
            ->closed()
            ->count(3)
            ->create();

        // Combine all 14 factory eateries.
        $factoryEateries = $openEateries->concat($closedEateries);

        foreach ($factoryEateries as $index => $factoryEatery) {

            // Create one permit through the relationship.
            // The first factory permit is guaranteed expired.
            $permitData = Permit::factory()->make()->only([
                'permit_no',
                'expires_on',
            ]);

            if ($index === 0) {
                $permitData['expires_on'] = now()
                    ->subYear()
                    ->toDateString();
            }

            $factoryEatery->permit()->create($permitData);

            // Give each eatery 2 to 5 dishes.
            Dish::factory()
                ->count(rand(2, 5))
                ->create([
                    'eatery_id' => $factoryEatery->id,
                ]);

            // Choose 1 to 3 random features.
            $randomFeatures = Feature::inRandomOrder()
                ->limit(rand(1, 3))
                ->pluck('id')
                ->all();

            // Use attach() as required by the handout.
            $factoryEatery->features()->attach($randomFeatures);
        }
    }
}
