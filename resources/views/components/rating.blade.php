@props([
    'rating' => null,
    'count' => null,
])

@if ($rating !== null)
    <span class="font-medium text-amber-700">
        {{ number_format((float) $rating, 1) }} ★

        @if ($count !== null)
            <span class="text-gray-600">
                ({{ $count }} {{ $count == 1 ? 'review' : 'reviews' }})
            </span>
        @endif
    </span>
@else
    <span class="text-gray-500">
        No reviews yet
    </span>
@endif
