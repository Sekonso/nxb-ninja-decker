<x-layout title="layout">
    <h1 class="text-4xl mb-4">GENERAL GUIDE</h1>

    <div>
        <h2 class="text-2xl mb-2">What is NxB Ninja Decker?</h2>
        <p>
            NarutoxBoruto Ninja Decker is a card collection game where you can collect various card based on the
            characters of Naruto/Boruto franchise.
        </p>

        <div class="my-5"></div>

        <h2 class="text-2xl mb-2">How do i play it?</h2>
        <p>The collection system is simple. You can go to the <a href="/gacha" class="text-accent">gacha</a> page and either do daily draw or paid draw with
            100 coins. You can see all the cards you have (and have not) collected in the <a href="/codex" class="text-accent">codex</a> page
        </p>

        <div class="my-5"></div>

        <h2 class="text-2xl mb-2">I can do free daily draw?</h2>
        <p>Yes, each day based on the server time (WIB) you can do one free draw.</p>

        <div class="my-5"></div>

        <h2 class="text-2xl mb-2">What do i get from a draw?</h2>
        <p>Both daily and paid will give you 3 cards per each draws.</p>

        <div class="my-5"></div>

        <h2 class="text-2xl mb-2">What happened if i get duplicate from a draw?</h2>
        <p>Any duplicate will be converted into various amount of coins based on rarities.</p>

        <div class="my-5"></div>

        <h2 class="text-2xl mb-2">Rarity Table</h2>
        <p>Currently, this game has 3 rarities (C, R, SR). You can refer to the detailed information about each rarity
            below</p>

        <div class="my-6"></div>

        <div class="overflow-x-auto">
            <table class="table border-5 border-primary">
                <thead class="bg-primary text-primary-content">
                    <tr>
                        <th>Name</th>
                        <th>Symbol</th>
                        <th>Drop Rate</th>
                        <th>Duplicate reward</th>
                    </tr>
                </thead>
                <tbody class="bg-white bg-base-content">
                    <tr>
                        <td>Common (C)</td>
                        <td><img src="{{ asset('storage/images/rarities/rarity_C.svg') }}" alt="rarity c" class="size-6"></td>
                        <td>65%</td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td>Rare (R)</td>
                        <td><img src="{{ asset('storage/images/rarities/rarity_R.svg') }}" alt="rarity r" class="size-6"></td>
                        <td>25%</td>
                        <td>25</td>
                    </tr>
                    <tr>
                        <td>Super Rare (SR)</td>
                        <td><img src="{{ asset('storage/images/rarities/rarity_SR.svg') }}" alt="rarity sr" class="size-6"></td>
                        <td>10%</td>
                        <td>50</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="my-5"></div>

        <h2 class="text-2xl mb-2">Disclaimer</h2>
        <p>This website is a fan project. It is not affiliated with, endorsed, sponsored, or approved by the rights
            holders, creators, publishers, or distributors of Naruto/Boruto. All trademarks, logos, character names,
            images, and other intellectual property related to Naruto remain the property of their respective owners. No
            copyright infringement is intended. This project is provided for informational and educational purposes
            only.</p>
    </div>
</x-layout>