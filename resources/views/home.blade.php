@extends('layouts.app')

@section('content')

<section class="mb-10 rounded-2xl bg-orange-700 p-8 text-white">
    <h1 class="mb-3 text-3xl font-bold">
        Welcome to Kaon Ta! Davao!
    </h1>

    <p class="mb-5">
        Discover carinderias and eateries around Davao City.
    </p>

    <a href="{{ route('eateries.index') }}"
       class="inline-block rounded-lg bg-white px-5 py-3 font-semibold text-orange-800">
        Explore Eateries
    </a>
</section>

<div class="mb-12 grid grid-cols-1 gap-4 sm:grid-cols-3">

    <div class="rounded-xl bg-white p-6 text-center shadow-sm">
        <p class="text-3xl font-bold text-orange-700">
            {{ $eateryCount }}
        </p>
        <p>Eateries</p>
    </div>

    <div class="rounded-xl bg-white p-6 text-center shadow-sm">
        <p class="text-3xl font-bold text-orange-700">
            {{ $districtCount }}
        </p>
        <p>Districts</p>
    </div>

    <div class="rounded-xl bg-white p-6 text-center shadow-sm">
        <p class="text-3xl font-bold text-orange-700">
            {{ $reviewCount }}
        </p>
        <p>Reviews</p>
    </div>

</div>

<h2 class="mb-5 text-2xl font-bold">
    Top Rated Eateries
</h2>

<div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
    @forelse ($topEateries as $eatery)
        <x-eatery-card :eatery="$eatery" />
    @empty
        <p>No rated eateries yet.</p>
    @endforelse
</div>

@endsection
