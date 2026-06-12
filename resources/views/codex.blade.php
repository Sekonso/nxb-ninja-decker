<x-layout title="Codex">
    <div class="bg-accent text-accent-content p-4 mb-8">
        <h1 class="text-4xl">Shinobi Codex</h1>
    </div>

    {{-- CODEX --}}
    <div>

        @foreach ($rarities as $rarity)
            {{-- Rarity head --}}
            <div class="flex flex-row gap-4 items-center">
                <img src="{{ asset("storage/images/rarities/$rarity->filename") }}" alt="rarity icon" class="h-12">
                <div class="h-1 w-full bg-base-content"></div>
            </div>

            {{-- Card list --}}
            <div class="flex flex-row gap-6 my-12">
                @if ($all_cards_by_rarity->has($rarity->id))

                    <div class="grid grid-cols-3  gap-6">
                        @foreach ($all_cards_by_rarity[$rarity->id] as $card)
                            <div class="hover-3d" onclick="document.getElementById('card_modal-{{ $card->id }}').showModal()">

                                <!-- content -->
                                <figure class="
                                        @if (!$card->owned) 
                                            grayscale brightness-10
                                        @elseif ($rarity->name == 'SR') 
                                            premium-card 
                                        @endif 
                                        rounded-lg">
                                    <img src="{{ asset('storage/images/cards/' . $card->filename) }}"
                                        alt="Card: {{ $card->name }}" />
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

                                @if (!$card->owned)
                                    <div class="absolute inset-0 flex items-center justify-center text-head text-5xl text-white">
                                        ?
                                    </div>
                                @else
                                    <dialog id="card_modal-{{ $card->id }}" class="modal">
                                        <div class="modal-box w-80 bg-transparent shadow-none">
                                            <img src="{{ asset('storage/images/cards/' . $card->filename) }}"
                                                alt="Card: {{ $card->name }}" class="w-full rounded-xl" />
                                        </div>

                                        <form method="dialog" class="modal-backdrop">
                                            <button>close</button>
                                        </form>
                                    </dialog>
                                @endif

                            </div>
                        @endforeach
                    </div>

                @else
                    <div class="w-full flex flex-row items-center justify-center">
                        <p class="text-head">Card for this rarity haven't been built</p>

                        <img src="{{ asset('storage/images/empty_deck.webp') }}" alt="naruto_kyunnn"
                            class="h-18 w-18 object-cover object-center">
                    </div>
                @endif
            </div>
        @endforeach

    </div>
</x-layout>