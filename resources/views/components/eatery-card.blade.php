@props(['eatery'])

@php
    // Convert price ranges into peso symbols.
    $prices = [
        'budget' => '₱',
        'mid' => '₱₱',
        'splurge' => '₱₱₱',
    ];
@endphp

<article class="rounded-xl border border-orange-100 bg-white p-5 shadow-sm">

    <div class="mb-3 flex items-start justify-between gap-2">
        <h3 class="text-lg font-bold text-orange-800">
            <a href="{{ route('eateries.show', $eatery) }}"
               class="hover:underline">
                {{ $eatery->name }}
            </a>
        </h3>

        @if (!$eatery->is_open)
            <span class="rounded bg-red-100 px-2 py-1 text-xs font-semibold text-red-700">
                Closed
            </span>
        @endif
    </div>

    <p class="mb-2 text-sm">
        District:
        <a href="{{ route('districts.show', $eatery->district) }}"
           class="text-orange-700 hover:underline">
            {{ $eatery->district->name }}
        </a>
    </p>

    <p class="mb-2 font-semibold">
        {{ $prices[$eatery->price_range] ?? '₱' }}
    </p>

    @if ($eatery->specialty)
        <p class="mb-3 text-sm">
            Specialty: {{ $eatery->specialty }}
        </p>
    @endif

    <div class="mb-4 flex flex-wrap gap-2">
        @foreach ($eatery->features as $feature)
            <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
               class="rounded-full bg-orange-100 px-3 py-1 text-xs text-orange-800">
                {{ $feature->name }}
            </a>
        @endforeach
    </div>

    <x-rating
        :rating="$eatery->reviews_avg_rating"
        :count="$eatery->reviews_count"
    />

</article>
