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

<!-- Eatery information -->
<section class="rounded-xl bg-white p-6 shadow-sm">

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

    <p class="mb-2">
        Address: {{ $eatery->address }}
    </p>

    <p class="mb-2">
        Price: {{ $prices[$eatery->price_range] ?? '₱' }}
    </p>

    <p class="mb-4">
        Specialty: {{ $eatery->specialty ?? 'Not specified' }}
    </p>

    <div class="mb-5 flex flex-wrap gap-2">
        @foreach ($eatery->features as $feature)
            <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
               class="rounded-full bg-orange-100 px-3 py-1 text-sm text-orange-800">
                {{ $feature->name }}
            </a>
        @endforeach
    </div>

    <!-- Edit and delete actions -->
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('eateries.edit', $eatery) }}"
           class="rounded bg-amber-500 px-4 py-2 text-white">
            Edit Eatery
        </a>

        <form method="POST"
              action="{{ route('eateries.destroy', $eatery) }}"
              onsubmit="return confirm('Delete this eatery and all its related records?')">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="rounded bg-red-700 px-4 py-2 text-white">
                Delete Eatery
            </button>
        </form>
    </div>
</section>

<!-- Business permit -->
<section class="mt-8 rounded-xl bg-white p-6 shadow-sm">
    <h2 class="mb-4 text-2xl font-bold">
        Business Permit
    </h2>

    @if ($eatery->permit)
        <p>
            Permit Number: {{ $eatery->permit->permit_no }}
        </p>

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
    <h2 class="mb-4 text-2xl font-bold">
        Menu and Dishes
    </h2>

    <div class="space-y-3">
        @forelse ($eatery->dishes as $dish)
            <div class="flex flex-wrap justify-between gap-3 border-b pb-3">
                <div>
                    <span class="font-medium">
                        {{ $dish->name }}
                    </span>

                    @if ($dish->is_bestseller)
                        <span class="ml-2 rounded bg-yellow-100 px-2 py-1 text-xs text-yellow-800">
                            Bestseller
                        </span>
                    @endif
                </div>

                <span>
                    ₱{{ number_format($dish->price, 2) }}
                </span>
            </div>
        @empty
            <p>No dishes listed yet.</p>
        @endforelse
    </div>
</section>

<!-- Existing reviews -->
<section class="mt-8 rounded-xl bg-white p-6 shadow-sm">
    <h2 class="mb-5 text-2xl font-bold">
        Customer Reviews
    </h2>

    <div class="space-y-5">
        @forelse ($eatery->reviews as $review)
            <article class="border-b pb-4">

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

                <p class="mb-3">
                    {{ $review->body }}
                </p>

                <!-- Delete review with a DELETE request. -->
                <form method="POST"
                      action="{{ route('reviews.destroy', $review) }}"
                      onsubmit="return confirm('Delete this review?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="text-sm font-medium text-red-700 hover:underline">
                        Delete Review
                    </button>
                </form>
            </article>
        @empty
            <p>No reviews yet.</p>
        @endforelse
    </div>
</section>

<!-- Review submission -->
<section class="mt-8 rounded-xl bg-white p-6 shadow-sm">
    <h2 class="mb-4 text-2xl font-bold">
        Write a Review
    </h2>

    @if (!$eatery->is_open)
        <p class="text-red-700">
            This eatery is closed. Reviews are paused.
        </p>
    @else

        <form method="POST"
              action="{{ route('eateries.reviews.store', $eatery) }}"
              class="space-y-5">

            @csrf

            <!-- Error summary -->
            @if ($errors->any())
                <div class="rounded-lg border border-red-300 bg-red-50 p-4 text-red-700">
                    <p class="mb-2 font-bold">
                        Please correct the following errors:
                    </p>

                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Reviewer -->
            <div>
                <label for="user_id" class="mb-1 block font-medium">
                    Reviewer
                </label>

                <select id="user_id"
                        name="user_id"
                        class="w-full rounded-lg border p-3">

                    <option value="">Choose a reviewer</option>

                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            @selected(old('user_id') == $user->id)>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>

                @error('user_id')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Rating -->
            <div>
                <label for="rating" class="mb-1 block font-medium">
                    Rating
                </label>

                <select id="rating"
                        name="rating"
                        class="w-full rounded-lg border p-3">

                    <option value="">Choose a rating</option>

                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}"
                            @selected(old('rating') == $i)>
                            {{ $i }} {{ $i == 1 ? 'Star' : 'Stars' }}
                        </option>
                    @endfor
                </select>

                @error('rating')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Review body -->
            <div>
                <label for="body" class="mb-1 block font-medium">
                    Your Review
                </label>

                <textarea id="body"
                          name="body"
                          rows="4"
                          class="w-full rounded-lg border p-3"
                          placeholder="Write at least 10 characters">{{ old('body') }}</textarea>

                @error('body')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button type="submit"
                    class="rounded-lg bg-orange-700 px-6 py-3 font-semibold text-white">
                Post Review
            </button>
        </form>
    @endif
</section>

@endsection
