<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's user data.
     */
    public function run(): void
    {
        // 1. Empty user
        User::firstOrCreate(
            ['email' => 'adam@example.com'],
            [
                'name' => 'Adam',
                'password' => Hash::make('12345678'),
                'coins' => 300,
            ]
        );

        // 2. Rich user
        User::firstOrCreate(
            ['email' => 'eve@example.com'],
            [
                'name' => 'Eve',
                'password' => Hash::make('12345678'),
                'coins' => 99999,
            ]
        );

        // 3. Collector user
        $collector = User::firstOrCreate(
            ['email' => 'bryan@example.com'],
            [
                'name' => 'Bryan',
                'password' => Hash::make('12345678'),
                'coins' => 300,
            ]
        );

        $cards = Card::all();
        foreach ($cards as $card) {
            Collection::firstOrCreate([
                'user_id' => $collector->id,
                'card_id' => $card->id,
            ]);
        }
    }
}
