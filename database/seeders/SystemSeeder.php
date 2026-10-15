<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Rarity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's system data.
     */
    public function run(): void
    {
        // Seed rarities
        $rarities = ['C', 'R', 'SR'];
        $createdRarities = [];

        foreach ($rarities as $rarity) {
            $createdRarities[] = Rarity::create([
                'name' => $rarity,
                'filename' => "rarity_{$rarity}.svg",
            ]);
        }

        // Seed cards
        $cards = [
            // C
            ['Boruto Uzumaki', 'boruto_uzumaki.webp', 0],
            ['Naruto Uzumaki', 'naruto_uzumaki.webp', 0],
            ['Sasuke Uchiha', 'sasuke_uchiha.webp', 0],
            ['Sakura Haruno', 'sakura_haruno.webp', 0],
            ['Kakashi Hatake', 'kakashi_hatake.webp', 0],
            ['Sarada Uchiha', 'sarada_uchiha.webp', 0],
            ['Mitsuki', 'mitsuki.webp', 0],
            ['Gaara', 'gaara.webp', 0],
            ['Kawaki Uzumaki', 'kawaki_uzumaki.webp', 0],
            ['Himawari Uzumaki', 'himawari_uzumaki.webp', 0],
            ['Minato Namikaze', 'minato_namikaze.webp', 0],
            ['Itachi Uchiha', 'itachi_uchiha.webp', 0],
            ['Pain (Tendo)', 'pain_tendo.webp', 0],
            ['Momoshiki Otsusuki', 'momoshiki_otsusuki.webp', 0],
            ['Mecha Kyubi', 'mecha_kyubi.webp', 0],
            ['Naruto Incomplete KCM (SD)', 'naruto_incomplete_kcm_sd.webp', 0],
            ['John Jonin', 'john_jonin.webp', 0],

            // R
            ['Mitsuki (artificial bond)', 'mitsuki_artificial_bond.webp', 1],
            ['Shikamaru (Singularity of Hope)', 'shikamaru_singularity_of_hope.webp', 1],
            ['Naruto & Jiraiya (Master & Student)', 'naruto_jiraiya_master_student.webp', 1],
            ['Deidara (Destroyer of the Worlds)', 'deidara_destroyer_of_the_worlds.webp', 1],
            ['Kawaki (Fresh Upgrade)', 'kawaki_fresh_upgrade.webp', 1],
            ['Kakashi(Free Day)', 'kakashi_free_day.webp', 1],

            // SR
            ['Boruto (Rogue Hero)', 'boruto_rogue_hero.webp', 2],
            ['Naruto (To Protect)', 'naruto_to_protect.webp', 2],
            ['Sasuke (To Destroy)', 'sasuke_to_destroy.webp', 2],
        ];

        foreach ($cards as $card) {
            Card::create([
                'name' => $card[0],
                'filename' => $card[1],
                'rarity_id' => $createdRarities[$card[2]]->id,
            ]);
        }
    }
}
