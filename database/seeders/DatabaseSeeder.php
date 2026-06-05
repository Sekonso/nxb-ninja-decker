<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Collection;
use App\Models\Rarity;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User
        $users = [
            ['Adam', 'adam@example.com', '12345678'],
            ['Eve', 'eve@example.com', '12345678'],
            ['Bobby', 'bobby@example.com', '12345678'],
            ['Cindy', 'cindy@example.com', '12345678'],
        ];
        $createdUsers = [];

        foreach ($users as $user) {
            $newUser = User::create([
                'name' => $user[0],
                'email' => $user[1],
                'password' => Hash::make($user[2]),
            ]);

            array_push($createdUsers, $newUser);
        }

        // Rarity
        $rarities = ['C', 'R', 'SR'];
        $createdRarities = [];

        foreach ($rarities as $rarity) {
            $newRarity = Rarity::create([
                'name' => $rarity, 
                'filename' => "rarity_$rarity.svg"]);
            array_push($createdRarities, $newRarity);
        }

        // Card
        $cards = [
            ['Boruto Uzumaki (base)', 'boruto_uzumaki_base.png', 0],
            ['Naruto Uzumaki (base)', 'naruto_uzumaki_base.png', 0],
            ['Gaara (base)', 'gaara_base.png', 0],
            ['Mitsuki (artificial bond)', 'mitsuki_artificial_bond.png', 1],
        ];
        $createdCards = [];

        foreach ($cards as $card) {
            $newCard = Card::create([
                'name' => $card[0],
                'filename' => $card[1],
                'rarity_id' => $createdRarities[$card[2]]->id,
            ]);
            array_push($createdCards, $newCard);
        }

        // Collections
        $collections = [
            [$createdUsers[0]->id, $createdCards[0]->id],
            [$createdUsers[0]->id, $createdCards[1]->id],
            [$createdUsers[0]->id, $createdCards[2]->id],
            [$createdUsers[0]->id, $createdCards[3]->id],
            [$createdUsers[1]->id, $createdCards[0]->id],
            [$createdUsers[1]->id, $createdCards[1]->id],
        ];
        $createdCollections = [];

        foreach ($collections as $collection) {
            $newCollection = Collection::create([
                'user_id' => $collection[0],
                'card_id' => $collection[1],
            ]);
            array_push($createdCollections, $newCollection);
        }
    }
}
