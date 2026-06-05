<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Rarity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{

    public function home()
    {
        $user = Auth::user();
        $rarities = Rarity::get();
        $my_cards = $user->collections->pluck('card');
        $my_cards_by_rarity = $my_cards->groupBy('rarity_id');

        return view('home', [
            'user' => $user,
            'my_cards_by_rarity' => $my_cards_by_rarity,
            'rarities' => $rarities
        ]);
    }

    public function codex()
    {
        $user = Auth::user();
        $rarities = Rarity::get();
        $all_cards = Card::get();
        $my_cards = $user->collections->pluck('card');
        
        // filter ownership
        $all_cards->each(function ($card) use ($my_cards) {
            $card->owned = $my_cards->contains('id', $card->id);
        });

        $all_cards_by_rarity = $all_cards->groupBy('rarity_id');

        return view('codex', [
            'rarities' => $rarities,
            'all_cards_by_rarity' => $all_cards_by_rarity,
        ]);
    }
}
