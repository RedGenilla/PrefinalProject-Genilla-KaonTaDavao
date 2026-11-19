<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEateryRequest;
use App\Http\Requests\UpdateEateryRequest;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EateryController extends Controller
{
    // Show eateries with combined filters.
    public function index(Request $request)
    {
        $query = Eatery::with(['district', 'features'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        if ($request->filled('q')) {
            $search = $request->query('q');

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('specialty', 'like', "%{$search}%");
            });
        }

        if ($request->filled('district')) {
            $query->where(
                'district_id',
                $request->query('district')
            );
        }

        if ($request->filled('feature')) {
            $feature = $request->query('feature');

            $query->whereHas('features', function ($q) use ($feature) {
                $q->where('name', $feature);
            });
        }

        $eateries = $query->orderBy('name')
            ->paginate(6)
            ->withQueryString();

        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.index', compact(
            'eateries', 'districts', 'features'
        ));
    }

    // Display the create form.
    public function create()
    {
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.create', compact(
            'districts', 'features'
        ));
    }

    // Save a new eatery and its related records.
    public function store(StoreEateryRequest $request)
    {
        $data = $request->validated();

        $eatery = DB::transaction(function () use ($data) {
            $eatery = Eatery::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'district_id' => $data['district_id'],
                'address' => $data['address'],
                'price_range' => $data['price_range'],
                'specialty' => $data['specialty'] ?? null,
                'is_open' => $data['is_open'] ?? false,
            ]);

            // Create the permit through the relationship.
            $eatery->permit()->create([
                'permit_no' => $data['permit_no'],
                'expires_on' => $data['expires_on'],
            ]);

            // Save selected features in the pivot table.
            $eatery->features()->sync($data['features']);

            return $eatery;
        });

        return redirect()
            ->route('eateries.show', $eatery)
            ->with('success', 'Eatery added.');
    }

    // Display one eatery with eager-loaded data.
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
            'eatery', 'users'
        ));
    }

    // Display the edit form.
    public function edit(Eatery $eatery)
    {
        $eatery->load(['permit', 'features']);

        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.edit', compact(
            'eatery', 'districts', 'features'
        ));
    }

    // Update the eatery, permit, and features.
    public function update(
        UpdateEateryRequest $request,
        Eatery $eatery
    ) {
        $data = $request->validated();

        DB::transaction(function () use ($eatery, $data) {
            $eatery->update([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'district_id' => $data['district_id'],
                'address' => $data['address'],
                'price_range' => $data['price_range'],
                'specialty' => $data['specialty'] ?? null,
                'is_open' => $data['is_open'] ?? false,
            ]);

            // Update or create its one permit.
            $eatery->permit()->updateOrCreate(
                [],
                [
                    'permit_no' => $data['permit_no'],
                    'expires_on' => $data['expires_on'],
                ]
            );

            // Replace old feature selections.
            $eatery->features()->sync($data['features']);
        });

        return redirect()
            ->route('eateries.show', $eatery)
            ->with('success', 'Eatery updated.');
    }

    // Delete the eatery and its related records.
    public function destroy(Eatery $eatery)
    {
        DB::transaction(function () use ($eatery) {
            $eatery->permit()->delete();
            $eatery->dishes()->delete();
            $eatery->reviews()->delete();

            // Remove feature pivot records.
            $eatery->features()->detach();

            $eatery->delete();
        });

        return redirect()
            ->route('eateries.index')
            ->with('success', 'Eatery deleted.');
    }
}
