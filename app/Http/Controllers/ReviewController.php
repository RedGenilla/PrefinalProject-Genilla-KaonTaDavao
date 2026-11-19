<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Eatery;
use App\Models\Review;

class ReviewController extends Controller
{
    // Save a review for an open eatery.
    public function store(
        StoreReviewRequest $request,
        Eatery $eatery
    ) {
        $data = $request->validated();

        // Create through the eatery relationship.
        $eatery->reviews()->create($data);

        return redirect()
            ->route('eateries.show', $eatery)
            ->with('success', 'Salamat! Review posted.');
    }

    // Delete a review.
    public function destroy(Review $review)
    {
        // Save the eatery before deleting the review.
        $eatery = $review->eatery;

        $review->delete();

        return redirect()
            ->route('eateries.show', $eatery)
            ->with('success', 'Review deleted.');
    }
}
