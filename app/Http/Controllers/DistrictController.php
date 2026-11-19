<?php

namespace App\Http\Controllers;

use App\Models\District;

class DistrictController extends Controller
{
    // List districts with their eatery counts.
    public function index()
    {
        $districts = District::withCount('eateries')
            ->orderBy('name')
            ->get();

        return view('districts.index', compact('districts'));
    }

    // Show eateries and review count for one district.
    public function show(District $district)
    {
        $district->load([
            'eateries' => fn ($q) => $q
                ->with(['district', 'features'])
                ->withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->orderBy('name'),
        ]);

        // Uses the hasManyThrough relationship.
        $reviewCount = $district->reviews()->count();

        return view('districts.show', compact(
            'district',
            'reviewCount'
        ));
    }
}
