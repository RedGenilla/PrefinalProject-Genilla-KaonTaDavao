@extends('layouts.app')

@section('content')

@php
    $prices = [
        'budget' => '₱',
        'mid' => '₱₱',
        'splurge' => '₱₱₱',
    ];
@endphp

<a href="{{ route('eateries.index') }}"
   class="mb-5 inline-block text-orange-700 hover:underline">
    Back to Eateries
</a>

<div class="rounded-xl bg-white p-6 shadow-sm">

    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-3xl font-bold text-orange-800">
            {{ $eatery->name }}
        </h1>

        @if (!$eatery->is_open)
            <span class="rounded bg-red-100 px-3 py-1 text-red-700">
                Closed
            </span>
        @endif
    </div>

    <p class="mb-2">
        District:
        <a href="{{ route('districts.show', $eatery->district) }}"
           class="text-orange-700 hover:underline">
            {{ $eatery->district->name }}
        </a>
    </p>

    <p class="mb-2">Address: {{ $eatery->address }}</p>
    <p class="mb-2">Price: {{ $prices[$eatery->price_range] ?? '₱' }}</p>
    <p class="mb-4">Specialty: {{ $eatery->specialty ?? 'Not specified' }}</p>

    <div class="mb-5 flex flex-wrap gap-2">
        @foreach ($eatery->features as $feature)
            <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
               class="rounded-full bg-orange-100 px-3 py-1 text-sm text-orange-800">
                {{ $feature->name }}
            </a>
        @endforeach
    </div>

    <div class="flex gap-3">
        <a href="{{ route('eateries.edit', $eatery) }}"
           class="rounded bg-amber-500 px-4 py-2 text-white">
            Edit Eatery
        </a>

        <!-- Delete form will be added in Step 7. -->
    </div>
</div>

<!-- Permit information -->
<section class="mt-8 rounded-xl bg-white p-6 shadow-sm">
    <h2 class="mb-4 text-2xl font-bold">Business Permit</h2>

    @if ($eatery->permit)
        <p>Permit Number: {{ $eatery->permit->permit_no }}</p>
        <p>
            Expires:
            {{ $eatery->permit->expires_on->format('F j, Y') }}
        </p>

        @if ($eatery->permit->expires_on->isPast())
            <p class="mt-2 font-bold text-red-600">
                Permit expired
            </p>
        @endif
    @else
        <p>No permit available.</p>
    @endif
</section>

<!-- Dishes -->
<section class="mt-8 rounded-xl bg-white p-6 shadow-sm">
    <h2 class="mb-4 text-2xl font-bold">Menu and Dishes</h2>

    <div class="space-y-3">
        @forelse ($eatery->dishes as $dish)
            <div class="flex flex-wrap justify-between gap-3 border-b pb-3">
                <div>
                    <span class="font-medium">{{ $dish->name }}</span>

                    @if ($dish->is_bestseller)
                        <span class="ml-2 rounded bg-yellow-100 px-2 py-1 text-xs text-yellow-800">
                            Bestseller
                        </span>
                    @endif
                </div>

                <span>₱{{ number_format($dish->price, 2) }}</span>
            </div>
        @empty
            <p>No dishes listed yet.</p>
        @endforelse
    </div>
</section>

<!-- Reviews -->
<section class="mt-8 rounded-xl bg-white p-6 shadow-sm">
    <h2 class="mb-5 text-2xl font-bold">Customer Reviews</h2>

    <div class="space-y-5">
        @forelse ($eatery->reviews as $review)
            <div class="border-b pb-4">
                <a href="{{ route('reviewers.show', $review->user) }}"
                   class="font-semibold text-orange-700 hover:underline">
                    {{ $review->user->name }}
                </a>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $review->created_at->format('M d, Y') }}
                </p>

                <div class="my-2">
                    <x-rating :rating="$review->rating" />
                </div>

                <p>{{ $review->body }}</p>

                <!-- Review delete form will be added in Step 7. -->
            </div>
        @empty
            <p>No reviews yet.</p>
        @endforelse
    </div>
</section>

<!-- Review form -->
<section class="mt-8 rounded-xl bg-white p-6 shadow-sm">
    <h2 class="mb-4 text-2xl font-bold">Write a Review</h2>

    @if (!$eatery->is_open)
        <p class="text-red-700">
            This eatery is closed. Reviews are paused.
        </p>
    @else
        <p class="text-gray-600">
            Review submission will be available in Step 7.
        </p>
    @endif
</section>

@endsection
