<x-layout-home title="Home">
    <div class="flex h-full flex-col p-6 sm:p-8">

        {{-- Cover image --}}
        <div class="flex-1 min-h-0">
            <img src="{{ asset('storage/images/cover.webp') }}" alt="Manga cover"
                class="h-full w-full object-cover" />
        </div>

        {{-- Logo --}}
        <div class="shrink-0 mt-6 sm:mt-8 flex justify-center hover:scale-105 transition-transform duration-300">
            <a href="/my-page">
                <img src="{{ asset('storage/images/logos.png') }}" alt="NxB Ninja Decker" class="w-40 sm:w-56" />
            </a>
        </div>

    </div>
</x-layout-home>
