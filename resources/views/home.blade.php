<x-layout title="My Page">
    {{-- PROFILE --}}
    <div>
        {{-- <h2 class="text-4xl mb-4">Profile</h2> --}}
        <div class="w-full p-6 flex flex-col sm:flex-row gap-6 items-center justify-between bg-secondary text-secondary-content">
            <div class="flex flex-row gap-6 items-center">
                <img src="{{ asset('storage/images/avatars/' . $user->avatar_filename) }}" alt="profile picture"
                    class="h-16 w-16 object-cover object-center">
                <span class="text-head text-4xl">{{ $user->name }}</span>
            </div>

            <div class="flex flex-row flex-wrap gap-2 items-center justify-end w-full sm:w-30">
                <a href="/profile/edit" class="btn btn-accent text-head w-full">Edit profile</a>
                <form action="/logout" method="post" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error w-full">Logout</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Divider --}}
    <div class="my-12"></div>

    {{-- MY CARDS --}}
    <div>
        <h2 class="text-4xl mb-4">My Cards</h2>
        @foreach ($rarities as $rarity)
            {{-- Rarity head --}}
            <div class="flex flex-row gap-4 items-center">
                <img src="{{ asset("storage/images/rarities/$rarity->filename") }}" alt="rarity icon" class="h-12">
                <div class="h-1 w-full bg-base-content"></div>
            </div>

            {{-- Card list --}}
            <div class="flex flex-row gap-6 my-12">
                @if ($my_cards_by_rarity->has($rarity->id))

                    <div class="grid grid-cols-3 gap-6">
                        @foreach ($my_cards_by_rarity[$rarity->id] as $card)
                            <div class="hover-3d cursor-pointer"
                                onclick="document.getElementById('card_modal-{{ $card->id }}').showModal()">

                                <figure class="rounded-lg @if ($rarity->name == 'SR') premium-card @endif">
                                    <img src="{{ asset('storage/images/cards/' . $card->filename) }}"
                                        alt="Card: {{ $card->name }}" />
                                </figure>

                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>

                            <dialog id="card_modal-{{ $card->id }}" class="modal">
                                <div class="modal-box w-80 p-2 bg-transparent shadow-none">
                                    <img src="{{ asset('storage/images/cards/' . $card->filename) }}" alt="Card: {{ $card->name }}"
                                        class="w-full rounded-xl" />
                                </div>

                                <form method="dialog" class="modal-backdrop">
                                    <button>close</button>
                                </form>
                            </dialog>
                        @endforeach
                    </div>

                @else
                    <div class="w-full flex flex-row items-center justify-center">
                        <p class="text-head">You have no cards yet</p>

                        <img src="{{ asset('storage/images/empty_deck.webp') }}" alt="naruto_kyunnn"
                            class="h-18 w-18 object-cover object-center">
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</x-layout>