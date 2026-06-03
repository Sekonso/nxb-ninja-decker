<x-layout>
    <div class="w-xs flex flex-row my-12">
        @foreach ($my_cards as $card)
            <div class="hover-3d">
                <!-- content -->
                <figure class="w-60 rounded-2xl">
                    <img src="{{ asset('storage/images/cards/' . $card->filename) }}" alt="Tailwind CSS 3D card" />
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
        @endforeach
    </div>

    <form action="/logout" method="post">
        @csrf
        @method('DELETE')


        <button type="submit" class="btn btn-primary">Logout</button>
    </form>
</x-layout>