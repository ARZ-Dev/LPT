<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        $data = [];
        $data['players'] = Player::all();

        return view('frontend.players.index', $data);
    }

    public function view(Player $player)
    {
        $data = [];
        $data['player'] = $player;

        return view('frontend.players.view', $data);
    }
}
