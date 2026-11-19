<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\Request;

class EateryController extends Controller
{
    // Show eateries with combined filters and pagination.
    public function index(Request $request)
    {
        $query = Eatery::query()
            ->with(['district', 'features'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        // Search name or specialty.
        if ($request->filled('q')) {
            $search = $request->query('q');

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('specialty', 'like', "%{$search}%");
            });
        }

        // Filter by district ID.
        if ($request->filled('district')) {
            $query->where(
                'district_id',
                $request->query('district')
            );
        }

        // Filter by feature name.
        if ($request->filled('feature')) {
            $feature = $request->query('feature');

            $query->whereHas('features', function ($q) use ($feature) {
                $q->where('name', $feature);
            });
        }

        // Six eateries per page, ordered A-Z.
        $eateries = $query
            ->orderBy('name')
            ->paginate(6)
            ->withQueryString();

        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.index', compact(
            'eateries',
            'districts',
            'features'
        ));
    }

    // Display the create form (completed in Step 7).
    public function create()
    {
        abort(501, 'Create form not implemented yet.');
    }

    // Save an eatery (completed in Step 7).
    public function store(Request $request)
    {
        abort(501, 'Store action not implemented yet.');
    }

    // Show one eatery using slug binding.
    public function show(Eatery $eatery)
    {
        $eatery->load([
            'district',
            'permit',
            'dishes',
            'features',
            'reviews' => fn ($q) => $q
                ->with('user')
                ->latest(),
        ]);

        $users = User::orderBy('name')->get();

        return view('eateries.show', compact(
            'eatery',
            'users'
        ));
    }

    // Display the edit form (completed in Step 7).
    public function edit(Eatery $eatery)
    {
        abort(501, 'Edit form not implemented yet.');
    }

    // Update an eatery (completed in Step 7).
    public function update(Request $request, Eatery $eatery)
    {
        abort(501, 'Update action not implemented yet.');
    }

    // Delete an eatery (completed in Step 7).
    public function destroy(Eatery $eatery)
    {
        abort(501, 'Delete action not implemented yet.');
    }
}
