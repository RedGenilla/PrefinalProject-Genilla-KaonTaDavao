<?php

namespace App\Http\Controllers;

use App\Models\Eatery;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Implemented with StoreReviewRequest in Step 7.
    public function store(Request $request, Eatery $eatery)
    {
        abort(501, 'Review form not implemented yet.');
    }

    // Implemented in Step 7.
    public function destroy(Review $review)
    {
        abort(501, 'Review deletion not implemented yet.');
    }
}
