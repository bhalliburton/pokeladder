<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Game;
use Illuminate\Support\Facades\Auth;

class ConflictingGames extends Controller
{
    //
    public function index()
    {
    	$games = \DB::table('games')->select('user_id', 'opponent', 'accepted', 'reported_winner', 'winner_file', 'created_at', 'game_id')->where('winner', null)->orderBy('created_at','desc')->get()->toArray();
    	return view('conflictinggames', compact('games'));
    }

}
