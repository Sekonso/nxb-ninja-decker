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
            ['Adam', 'adam@example.com', '12345678', 99999],
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
                'coins' => ($user[3] ?? null) ?: 300
            ]);

            array_push($createdUsers, $newUser);
        }

        // Rarity
        $rarities = ['C', 'R', 'SR'];
        $createdRarities = [];

        foreach ($rarities as $rarity) {
            $newRarity = Rarity::create([
                'name' => $rarity,
                'filename' => "rarity_$rarity.svg"
            ]);
            array_push($createdRarities, $newRarity);
        }

        // Card
        $cards = [
            // C
            ['Boruto Uzumaki', 'boruto_uzumaki.png', 0],
            ['Naruto Uzumaki', 'naruto_uzumaki.png', 0],
            ['Sasuke Uchiha', 'sasuke_uchiha.png', 0],
            ['Sakura Haruno', 'sakura_haruno.png', 0],
            ['Kakashi Hatake', 'kakashi_hatake.png', 0],
            ['Sarada Uchiha', 'sarada_uchiha.png', 0],
            ['Mitsuki', 'mitsuki.png', 0],
            ['Gaara', 'gaara.png', 0],
            ['Kawaki Uzumaki', 'kawaki_uzumaki.png', 0],
            ['Himawari Uzumaki', 'himawari_uzumaki.png', 0],
            ['Minato Namikaze', 'minato_namikaze.png', 0],
            ['Itachi Uchiha', 'itachi_uchiha.png', 0],
            ['Pain (Tendo)', 'pain_tendo.png', 0],
            ['Momoshiki Otsusuki', 'momoshiki_otsusuki.png', 0],
            ['Mecha Kyubi', 'mecha_kyubi.png', 0],
            ['Naruto Incomplete KCM (SD)', 'naruto_incomplete_kcm_sd.png', 0],
            ['John Jonin', 'john_jonin.png', 0],

            // RR
            ['Mitsuki (artificial bond)', 'mitsuki_artificial_bond.png', 1],
            ['Shikamaru (Singularity of Hope)', 'shikamaru_singularity_of_hope.png', 1],
            ['Naruto & Jiraiya (Master & Student)', 'naruto_jiraiya_master_student.png', 1],
            ['Deidara (Destroyer of the Worlds)', 'deidara_destroyer_of_the_worlds.png', 1],
            ['Kawaki (Fresh Upgrade)', 'kawaki_fresh_upgrade.png', 1],
            ['Kakashi(Free Day)', 'kakashi_free_day.png', 1],

            // SR
            ['Boruto (Rogue Hero)', 'boruto_rogue_hero.png', 2],
            ['Naruto (To Protect)', 'naruto_to_protect.png', 2],
            ['Sasuke (To Destroy)', 'sasuke_to_destroy.png', 2],

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
        // $collections = [
        //     [$createdUsers[0]->id, $createdCards[0]->id],
        //     [$createdUsers[0]->id, $createdCards[1]->id],
        //     [$createdUsers[0]->id, $createdCards[2]->id],
        //     [$createdUsers[0]->id, $createdCards[3]->id],
        //     [$createdUsers[1]->id, $createdCards[0]->id],
        //     [$createdUsers[1]->id, $createdCards[1]->id],
        // ];
        // $createdCollections = [];

        // foreach ($collections as $collection) {
        //     $newCollection = Collection::create([
        //         'user_id' => $collection[0],
        //         'card_id' => $collection[1],
        //     ]);
        //     array_push($createdCollections, $newCollection);
        // }
    }
}
