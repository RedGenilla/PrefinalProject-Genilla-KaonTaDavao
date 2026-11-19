<nav class="bg-orange-700 text-white shadow">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-4 py-5">

        <a href="{{ route('home') }}"
           class="text-xl font-bold">
            Kaon Ta! Davao – Genilla's Food Guide
        </a>

        <div class="flex flex-wrap gap-4 text-sm font-medium">
            <a href="{{ route('home') }}" class="hover:underline">
                Home
            </a>

            <a href="{{ route('eateries.index') }}" class="hover:underline">
                Eateries
            </a>

            <a href="{{ route('districts.index') }}" class="hover:underline">
                Districts
            </a>

            <a href="{{ route('eateries.create') }}" class="hover:underline">
                Add Eatery
            </a>
        </div>

    </div>
</nav>
