<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Eatery;
use App\Models\Review;

class HomeController extends Controller
{
    public function __invoke()
    {
        // Count the main records for the dashboard.
        $eateryCount = Eatery::count();
        $districtCount = District::count();
        $reviewCount = Review::count();

        // Find the three highest-rated eateries with reviews.
        $topEateries = Eatery::with([
                'district',
                'features',
            ])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->has('reviews')
            ->orderByDesc('reviews_avg_rating')
            ->orderBy('name')
            ->take(3)
            ->get();

        return view('home', compact(
            'eateryCount',
            'districtCount',
            'reviewCount',
            'topEateries'
        ));
    }
}
