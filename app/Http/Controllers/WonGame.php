<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Match;
use App\Player;
use Illuminate\Support\Facades\Auth;


class WonGame extends Controller
{
    //
    public function index($won) // 1=winner, 0=loser
    {

	    $this->id = Auth::id();
		$this->player = User::find($this->id)->player;
    
 		$this->match = Match::where('user_id', $this->id)
            ->where('queue_format', $this->player->queue_format)
            ->where('queue_Bo', $this->player->queue_Bo)
            ->orderBy('created_at','desc')
            ->first();

		$this->oppmatch = Match::where('match_id', $this->match->match_id)
            ->where('opponent', $this->id)
            ->first();

        if($won == 1) {
        	$this->winner = $this->id;
        	$this->loser = $this->match->opponent;
        } else {
        	$this->winner = $this->match->opponent;
        	$this->loser = $this->id;
        }

	    $this->match->reported_winner = $this->winner;
    	$this->match->save();

        if(is_null($this->oppmatch->reported_winner)) {
        	// Opponent hasn't reported yet
			// If opponent hasn't marked yet, they can't queue, so don't mark the match resolved.

            // STUFF TO DO HERE! INFORM PERSON GAME NOT RESOLVED

        } else {
        	// Make sure opponent has same result
        	if($this->oppmatch->reported_winner != $this->winner) {
        		// Different winners! OH NO!!!!
        		// FREAK OUT PLS
        	} else {
            	// Same winner! Now we can mark the match done, mark the winner and increment their glicko
            	$this->match->winner = $this->winner;
        		$this->match->save();

        		$this->oppmatch->winner = $this->winner;
        		$this->oppmatch->save();

                $update = Match::updateGlicko($this->match->match_id);

        		$this->player->matched = 0;
    	       	$this->player->save();

        		$this->opp = User::find($this->match->opponent)->player;
        		$this->opp->matched = 0;
    	       	$this->opp->save();
            }
        }


		return redirect('/dashboard');
	}

}
