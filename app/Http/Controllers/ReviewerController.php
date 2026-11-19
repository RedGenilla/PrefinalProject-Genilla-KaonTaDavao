<?php

namespace App\Http\Controllers;

use App\Models\User;

class ReviewerController extends Controller
{
    // Show a reviewer's profile and reviews.
    public function show(User $user)
    {
        $user->load([
            'reviews' => fn ($q) => $q
                ->with('eatery')
                ->latest(),
        ]);

        return view('reviewers.show', compact('user'));
    }
}
