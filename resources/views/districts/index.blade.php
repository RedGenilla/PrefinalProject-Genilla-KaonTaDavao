@extends('layouts.app')

@section('content')

<h1 class="mb-6 text-3xl font-bold">
    Davao City Districts
</h1>

<div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">

    @foreach ($districts as $district)
        <a href="{{ route('districts.show', $district) }}"
           class="rounded-xl bg-white p-6 shadow-sm hover:shadow-md">

            <h2 class="mb-2 text-xl font-bold text-orange-800">
                {{ $district->name }}
            </h2>

            <p class="text-gray-600">
                {{ $district->eateries_count }}
                {{ $district->eateries_count == 1 ? 'eatery' : 'eateries' }}
            </p>
        </a>
    @endforeach

</div>

@endsection
