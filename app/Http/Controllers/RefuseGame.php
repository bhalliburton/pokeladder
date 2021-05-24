<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Player;
use App\Match;
use Illuminate\Support\Facades\Auth;

class RefuseGame extends Controller
{
    //
    public function index()
    {
    	$id = Auth::id();
	    $player = User::find($id)->player;
	    
        // Make player available for another game
        $player->queued = 0;
	    $player->matched = 0;
	    $player->save();

        // Note that he didn't accept
        $match = Match::where('user_id', $id)
            ->where('queue_format', $player->queue_format)
            ->where('queue_Bo', $player->queue_Bo)
            ->orderBy('created_at','desc')
            ->first();

        $match->accepted = 0;
        $match->save();

        // Note in opponent that this guy refused
        $rematch = Match::where('match_id', $match->match_id)
            ->where('opponent', $id)
            ->first();

        $rematch->accepted = 2;
        $rematch->save();

        // Clear opponent to play in another game
	    $replayer = User::find($rematch->user_id)->player;
	    $replayer->queued = 0;
	    $replayer->matched = 0;
	    $replayer->save();

	    return redirect('/dashboard');
	}
}
