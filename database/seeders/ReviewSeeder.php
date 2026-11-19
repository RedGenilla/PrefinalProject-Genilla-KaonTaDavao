<?php

namespace Database\Seeders;

use App\Models\Eatery;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Find the personalized eatery.
        $eatery = Eatery::where(
            'name',
            'Carinderia ni Genilla'
        )->firstOrFail();

        $tita = User::where(
            'email',
            'tita.genilla@kaonta.test'
        )->firstOrFail();

        $red = User::where(
            'email',
            'genilla@kaonta.test'
        )->firstOrFail();

        // Required five-star review by Tita Genilla.
        $eatery->reviews()->create([
            'user_id' => $tita->id,
            'rating' => 5,
            'body' => 'Lami kaayo! Balik-balikan ni Tita Genilla.',
        ]);

        // Two more reviews for the personalized eatery.
        $eatery->reviews()->create([
            'user_id' => $red->id,
            'rating' => 5,
            'body' => 'Lami ang tinolang manok ug barato ra!',
        ]);

        $otherUser = User::whereNotIn('id', [
            $tita->id,
            $red->id,
        ])->inRandomOrder()->firstOrFail();

        $eatery->reviews()->create([
            'user_id' => $otherUser->id,
            'rating' => 4,
            'body' => 'Delicious food and friendly service.',
        ]);

        // Create reviews only for other open eateries.
        $openEateries = Eatery::where('is_open', true)
            ->where('id', '!=', $eatery->id)
            ->get();

        foreach ($openEateries as $openEatery) {
            $reviewCount = rand(0, 6);

            // The factory provides user, rating and body.
            Review::factory()
                ->count($reviewCount)
                ->create([
                    'eatery_id' => $openEatery->id,
                ]);
        }
    }
}
