<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Rarity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GachaController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        return view('gacha.index', [
            'user' => $user
        ]);
    }

    public function result()
    {
        $stored_cards = session('stored_cards');

        if (!$stored_cards) {
            abort(400, 'Card results are not provided');
        }

        $all_cards = Card::all()->keyBy('id');

        $card_draws = collect();

        foreach ($stored_cards as $stored_card) {
            $card = clone $all_cards[$stored_card['id']];

            $card->is_duplicate = $stored_card['is_duplicate'];
            $card->convert_to_coins = $stored_card['is_duplicate']
                ? $this->convert_card_to_coins($card)
                : 0;

            $card_draws->push($card);
        }

        return view('gacha.result', [
            'card_draws' => $card_draws,
        ]);
    }

    public function gacha_daily()
    {
        $user = Auth::user();

        if (
            $user->latest_daily !== null &&
            $user->latest_daily >= today()->toDateTimeString()
        ) {
            abort(400, 'Your daily draw has been used. Try again tomorrow.');
        }

        $new_cards = $this->draw_cards();
        $stored_cards = DB::transaction(function () use ($user, $new_cards) {
            $stored_cards = $this->store_cards($user, $new_cards);
            $this->store_cards($user, $new_cards);

            $user->latest_daily = now()->toDateTimeString();
            $user->save();

            return $stored_cards;
        });

        return redirect('/gacha/result')->with('stored_cards', $stored_cards);
    }

    public function gacha_paid()
    {
        $user = Auth::user();

        if (!$user->coins || $user->coins < 100) {
            abort(400, 'You don\'t have enough coins');
        }

        $new_cards = $this->draw_cards();
        $stored_cards = DB::transaction(function () use ($user, $new_cards) {
            $stored_cards = $this->store_cards($user, $new_cards);

            $user->coins -= 100;
            $user->save();

            return $stored_cards;
        });

        return redirect('/gacha/result')->with('stored_cards', $stored_cards);
    }

    private function draw_cards(): Collection
    {
        $rarities = Rarity::with('cards')->get()->keyBy('name');

        $rarity_drop_rates = [
            'C' => 60,
            'R' => 30,
            // 'SR' => 10,
        ];
        $rarity_total_rate = array_sum($rarity_drop_rates);

        // drawing card rarities
        $rarity_draws = [];
        for ($i = 0; $i < 3; $i++) {
            $draw_val = random_int(1, $rarity_total_rate);
            $current = 0;

            foreach ($rarity_drop_rates as $rarity => $drop_rate) {
                $current += $drop_rate;

                if ($draw_val <= $current) {
                    array_push($rarity_draws, $rarity);
                    break;
                }
            }
        }

        // drawing cards based on rarities
        $card_draws = collect();
        foreach ($rarity_draws as $rarity) {
            $card = $rarities[$rarity]->cards->random();
            $card_draws->push($card);
        }

        return $card_draws;
    }

    private function store_cards(User $user, Collection $cards): Collection
    {
        $stored_cards = collect();

        foreach ($cards as $card) {
            $collection = \App\Models\Collection::firstOrCreate([
                'user_id' => $user->id,
                'card_id' => $card->id,
            ]);
            $isDuplicate = !$collection->wasRecentlyCreated;

            if ($isDuplicate) {
                $user->coins += $this->convert_card_to_coins($card);
            }

            $stored_cards->push([
                'id' => $card->id,
                'is_duplicate' => $isDuplicate,
            ]);
        }

        $user->save();
        return $stored_cards;
    }

    private function convert_card_to_coins(Card $card): int
    {
        $convert_rate = [
            'C' => 10,
            'R' => 25,
            'SR' => 50,
        ];

        $coins = $convert_rate[$card->rarity->name];

        return $coins;
    }
}
