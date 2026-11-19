@extends('layouts.app')

@section('content')

<a href="{{ route('districts.index') }}"
   class="mb-5 inline-block text-orange-700 hover:underline">
    Back to Districts
</a>

<h1 class="mb-3 text-3xl font-bold">
    {{ $district->name }}
</h1>

<p class="mb-8 text-gray-600">
    {{ $reviewCount }}
    {{ $reviewCount == 1 ? 'review' : 'reviews' }}
    in {{ $district->name }}
</p>

<h2 class="mb-5 text-2xl font-bold">
    Eateries in {{ $district->name }}
</h2>

<div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">

    @forelse ($district->eateries as $eatery)
        <x-eatery-card :eatery="$eatery" />
    @empty
        <p>No eateries in this district yet.</p>
    @endforelse

</div>

@endsection
