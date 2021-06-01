<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Game;
use Illuminate\Support\Facades\Auth;

class RecentGames extends Controller
{
    //
    public function index()
    {
    	$this->id = Auth::id();
	    $this->player = User::find($this->id)->player;

	    $games = Game::with(['user', 'opp', 'winners'])->where('user_id', $this->id)->where('accepted', '1')->orderBy('created_at','desc')->limit(10)->get();

	    $athing = array();
	    $i = 0;
	    // NEED TO SHOW RATINGS, THEY ARE IN THE QUEUE
	    foreach ($games as $game) {
	    	$athing[$i][0] = $game->user->username;
	    	$athing[$i][1] = $game->created_at;
	    	$athing[$i][2] = $game->opp->username;
	    	if($game->queue_format == 0) {
	    		$thing = "Standard Format";
	    	} else {
	    		$thing = "Expanded Format";
	    	}
	    	if($game->queue_Bo = 1) {
	    		$thing .= " Bo1";
	    	} else {
	    		$thing .= " Bo3";
	    	}
	    	$athing[$i][3] = $thing;
	    	if(is_Null($game->winner)) {
	    		$winner = "Game Ongoing";
	    	} else {
	    		$winner = $game->winners->username . " wins";
	    	}
	    	$athing[$i][4] = $winner;
	    	$i++;
	    }


	    return view('history', compact('athing'));
	}

	public function api($user)
	{
	    $this->user = User::where('username', $user)->first();

	    $games = Game::with(['user', 'opp', 'winners'])->where('user_id', $this->user->id)->where('accepted', '1')->orderBy('created_at','desc')->limit(10)->get();

	    $athing = array();
	    $i = 0;
	    // NEED TO SHOW RATINGS, THEY ARE IN THE QUEUE
	    foreach ($games as $game) {
	    	$athing[$i]['created_at'] = $game->created_at;
	    	$athing[$i]['user'] = $game->user->username;
	    	$athing[$i]['user_rating'] = $game->rating;
	    	$athing[$i]['opp'] = $game->opp->username;
	    	$athing[$i]['opp_rating'] = $game->opp_rating;
	    	if($game->queue_format == 0) {
	    		$thing = "Standard Format";
	    	} else {
	    		$thing = "Expanded Format";
	    	}
	    	if($game->queue_Bo = 1) {
	    		$thing .= " Bo1";
	    	} else {
	    		$thing .= " Bo3";
	    	}
	    	$athing[$i]['format'] = $thing;
	    	if(is_Null($game->winner)) {
	    		$winner = "Game Ongoing";
	    	} else {
	    		$winner = $game->winners->username . " wins";
	    	}
	    	$athing[$i]['outcome'] = $winner;
	    	$i++;
	    }


		return response()->json($athing);
	}


}
