@php
    // Check whether we are editing an existing eatery.
    $editing = isset($eatery);

    $selectedFeatures = old(
        'features',
        $editing ? $eatery->features->pluck('id')->all() : []
    );
@endphp

<form method="POST"
      action="{{ $editing
          ? route('eateries.update', $eatery)
          : route('eateries.store') }}"
      class="space-y-5 rounded-xl bg-white p-6 shadow-sm">

    @csrf

    @if ($editing)
        @method('PUT')
    @endif

    <!-- Validation summary -->
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

    <!-- Eatery name -->
    <div>
        <label for="name" class="mb-1 block font-medium">
            Eatery Name
        </label>

        <input type="text"
               id="name"
               name="name"
               value="{{ old('name', $eatery->name ?? '') }}"
               class="w-full rounded-lg border p-3">

        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- District -->
    <div>
        <label for="district_id" class="mb-1 block font-medium">
            District
        </label>

        <select id="district_id"
                name="district_id"
                class="w-full rounded-lg border p-3">

            <option value="">Select a district</option>

            @foreach ($districts as $district)
                <option value="{{ $district->id }}"
                    @selected(old('district_id', $eatery->district_id ?? '') == $district->id)>
                    {{ $district->name }}
                </option>
            @endforeach
        </select>

        @error('district_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Address -->
    <div>
        <label for="address" class="mb-1 block font-medium">
            Address
        </label>

        <input type="text"
               id="address"
               name="address"
               value="{{ old('address', $eatery->address ?? '') }}"
               class="w-full rounded-lg border p-3">

        @error('address')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Price range -->
    <div>
        <label for="price_range" class="mb-1 block font-medium">
            Price Range
        </label>

        <select id="price_range"
                name="price_range"
                class="w-full rounded-lg border p-3">

            <option value="">Select a price range</option>

            <option value="budget"
                @selected(old('price_range', $eatery->price_range ?? '') == 'budget')>
                Budget (₱)
            </option>

            <option value="mid"
                @selected(old('price_range', $eatery->price_range ?? '') == 'mid')>
                Mid (₱₱)
            </option>

            <option value="splurge"
                @selected(old('price_range', $eatery->price_range ?? '') == 'splurge')>
                Splurge (₱₱₱)
            </option>
        </select>

        @error('price_range')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Specialty -->
    <div>
        <label for="specialty" class="mb-1 block font-medium">
            Specialty (Optional)
        </label>

        <input type="text"
               id="specialty"
               name="specialty"
               value="{{ old('specialty', $eatery->specialty ?? '') }}"
               class="w-full rounded-lg border p-3">

        @error('specialty')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Open status -->
    <div>
        <!-- Unchecked checkbox submits false. -->
        <input type="hidden" name="is_open" value="0">

        <label class="flex items-center gap-2">
            <input type="checkbox"
                   name="is_open"
                   value="1"
                   @checked(old('is_open', $eatery->is_open ?? false))>

            <span>Currently Open</span>
        </label>

        @error('is_open')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Features -->
    <fieldset>
        <legend class="mb-2 font-medium">
            Features (Select at least one)
        </legend>

        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            @foreach ($features as $feature)
                <label class="flex items-center gap-2">
                    <input type="checkbox"
                           name="features[]"
                           value="{{ $feature->id }}"
                           @checked(in_array($feature->id, $selectedFeatures))>

                    <span>{{ $feature->name }}</span>
                </label>
            @endforeach
        </div>

        @error('features')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror

        @error('features.*')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </fieldset>

    <!-- Permit number -->
    <div>
        <label for="permit_no" class="mb-1 block font-medium">
            Permit Number
        </label>

        <input type="text"
               id="permit_no"
               name="permit_no"
               placeholder="DVO-2026-0915"
               value="{{ old('permit_no', $eatery->permit->permit_no ?? '') }}"
               class="w-full rounded-lg border p-3">

        @error('permit_no')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Permit expiry -->
    <div>
        <label for="expires_on" class="mb-1 block font-medium">
            Permit Expiry Date
        </label>

        <input type="date"
               id="expires_on"
               name="expires_on"
               value="{{ old('expires_on', $editing && $eatery->permit
                   ? $eatery->permit->expires_on->format('Y-m-d')
                   : '') }}"
               class="w-full rounded-lg border p-3">

        @error('expires_on')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Submit -->
    <div class="flex flex-wrap gap-3">
        <button type="submit"
                class="rounded-lg bg-orange-700 px-6 py-3 font-semibold text-white">
            {{ $editing ? 'Update Eatery' : 'Add Eatery' }}
        </button>

        <a href="{{ $editing
                ? route('eateries.show', $eatery)
                : route('eateries.index') }}"
           class="rounded-lg bg-gray-200 px-6 py-3">
            Cancel
        </a>
    </div>
</form>
