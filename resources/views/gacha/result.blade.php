<x-layout>
    <h1 class="text-center text-4xl">- DRAW RESULTS -</h1>

    <div class="carousel w-full space-x-4 p-6">
        @foreach ($card_draws as $card)
            <div class="carousel-item flex flex-col items-center gap-4">
                <div class="hover-3d">
                    <!-- content -->
                    <figure class="w-50 rounded-lg">
                        <img src="{{ asset('storage/images/cards/' . $card->filename) }}" alt="Card: {{ $card->name }}" />
                    </figure>

                    <!-- 8 empty divs needed for the 3D effect -->
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                
                @if ($card->is_duplicate)
                    <span class="text-head text-xl flex flex-row gap-2">
                        {{ $card->convert_to_coins }}
                        <img src="{{ asset('storage/images/coins.png') }}" alt="coins" class="size-6">
                    </span>
                @else
                    <span class="text-head text-xl">NEW!</span>
                @endif
            </div>
        @endforeach
    </div>

    <a href="/gacha" class="btn btn-accent w-full text-head text-2xl">
        Draw again
    </a>
</x-layout>