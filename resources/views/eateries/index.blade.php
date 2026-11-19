@extends('layouts.app')

@section('content')

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <h1 class="text-3xl font-bold">
        Explore Eateries
    </h1>

    <a href="{{ route('eateries.create') }}"
       class="rounded-lg bg-orange-700 px-4 py-2 text-white">
        Add Eatery
    </a>
</div>

<!-- All filters use one GET form. -->
<form method="GET"
      action="{{ route('eateries.index') }}"
      class="mb-8 grid grid-cols-1 gap-4 rounded-xl bg-white p-5 shadow-sm md:grid-cols-4">

    <div>
        <label for="q" class="mb-1 block text-sm font-medium">
            Search
        </label>

        <input id="q"
               type="text"
               name="q"
               value="{{ request('q') }}"
               placeholder="Name or specialty"
               class="w-full rounded-lg border border-gray-300 p-2">
    </div>

    <div>
        <label for="district" class="mb-1 block text-sm font-medium">
            District
        </label>

        <select id="district"
                name="district"
                class="w-full rounded-lg border border-gray-300 p-2">

            <option value="">All Districts</option>

            @foreach ($districts as $district)
                <option value="{{ $district->id }}"
                    @selected(request('district') == $district->id)>
                    {{ $district->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="feature" class="mb-1 block text-sm font-medium">
            Feature
        </label>

        <select id="feature"
                name="feature"
                class="w-full rounded-lg border border-gray-300 p-2">

            <option value="">All Features</option>

            @foreach ($features as $feature)
                <option value="{{ $feature->name }}"
                    @selected(request('feature') == $feature->name)>
                    {{ $feature->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="flex items-end gap-2">
        <button type="submit"
                class="rounded-lg bg-orange-700 px-4 py-2 text-white">
            Filter
        </button>

        <a href="{{ route('eateries.index') }}"
           class="rounded-lg bg-gray-200 px-4 py-2">
            Clear
        </a>
    </div>

</form>

<div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">

    @forelse ($eateries as $eatery)
        <x-eatery-card :eatery="$eatery" />
    @empty
        <p class="col-span-full text-center text-gray-600">
            No eateries match your filters.
        </p>
    @endforelse

</div>

<div class="mt-8">
    {{ $eateries->links() }}
</div>

@endsection
