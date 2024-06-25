<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Game;
use App\Models\HeroSection;
use App\Models\Player;
use App\Models\Tournament;
use App\Models\TournamentLevelCategory;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        $data = [];

        $data['upcomingMatches'] = Game::where('is_started', false)->where('datetime', '>', now())->orderBy('datetime')->with(['homeTeam', 'awayTeam'])->get();
        $data['lastMatches'] = Game::where('is_completed', true)->orderBy('datetime', 'desc')->take(3)->with(['homeTeam', 'awayTeam', 'sets'])->get();

        $data['menFirstRankPlayer'] = Player::where('gender', 'male')->where('rank', 1)->first();
        $data['menPlayers'] = Player::where('gender', 'male')->whereNot('rank', 1)->orderBy('rank')->get();

        $data['womenFirstRankPlayer'] = Player::where('gender', 'female')->where('rank', 1)->first();
        $data['womenPlayers'] = Player::where('gender', 'female')->whereNot('rank', 1)->orderBy('rank')->get();

        $data['heroSections'] = HeroSection::orderBy('order')->where('is_active', true)->get();
        $data['firstBlog'] = Blog::where('order', 1)->first();
        $data['blogs'] = Blog::whereNot('order', 1)->orderBy('order')->get();

        return view('frontend.home.home', $data);
    }
}
