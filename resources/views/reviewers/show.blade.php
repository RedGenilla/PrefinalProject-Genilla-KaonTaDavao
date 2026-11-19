@extends('layouts.app')

@section('content')

<h1 class="mb-3 text-3xl font-bold">
    {{ $user->name }}
</h1>

<p class="mb-8 text-gray-600">
    {{ $user->reviews->count() }}
    {{ $user->reviews->count() == 1 ? 'review' : 'reviews' }}
    written
</p>

<div class="space-y-5">

    @forelse ($user->reviews as $review)
        <article class="rounded-xl bg-white p-6 shadow-sm">

            <h2 class="mb-2 font-bold text-orange-800">
                <a href="{{ route('eateries.show', $review->eatery) }}"
                   class="hover:underline">
                    {{ $review->eatery->name }}
                </a>
            </h2>

            <x-rating :rating="$review->rating" />

            <p class="mt-3">{{ $review->body }}</p>

            <p class="mt-2 text-sm text-gray-500">
                {{ $review->created_at->format('M d, Y') }}
            </p>

        </article>
    @empty
        <p>This user has not written any reviews yet.</p>
    @endforelse

</div>

@endsection
