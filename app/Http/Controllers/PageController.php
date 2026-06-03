<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home() {
        $collections = Auth::user()->collections;
        $my_cards = [];

        foreach($collections as $collection) {
            $card = $collection->card;

            array_push($my_cards, $card);
        }

        return view('home', ['my_cards' => $my_cards]);
    }
}
