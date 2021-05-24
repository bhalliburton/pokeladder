<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Match;
use Illuminate\Support\Facades\Auth;

class RecentGames extends Controller
{
    //
    public function index()
    {
    	$this->id = Auth::id();
	    $this->player = User::find($this->id)->player;

	    $matches = Match::with(['user', 'opp', 'winners'])->where('user_id', $this->id)->where('accepted', '1')->orderBy('created_at','desc')->limit(10)->get();

	    $games = array();
	    $i = 0;
	    // NEED TO SHOW RATINGS, THEY ARE IN THE QUEUE
	    foreach ($matches as $match) {
	    	$games[$i][0] = $match->user->username;
	    	$games[$i][1] = $match->created_at;
	    	$games[$i][2] = $match->opp->username;
	    	if($match->queue_format = 0) {
	    		$thing = "Standard Format";
	    	} else {
	    		$thing = "Expanded Format";
	    	}
	    	if($match->queue_Bo = 1) {
	    		$thing .= " Bo1";
	    	} else {
	    		$thing .= " Bo3";
	    	}
	    	$games[$i][3] = $thing;
	    	if(is_Null($match->winner)) {
	    		$winner = "Match Ongoing";
	    	} else {
	    		$winner = $match->winners->username . " wins";
	    	}
	    	$games[$i][4] = $winner;
	    	$i++;
	    }


	    return view('history', compact('games'));
	}
}
