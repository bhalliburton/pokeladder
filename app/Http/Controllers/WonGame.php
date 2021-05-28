<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Game;
use App\Player;
use Illuminate\Support\Facades\Auth;


class WonGame extends Controller
{
    //
    public function index($won) // 1=winner, 0=loser
    {

	    $this->id = Auth::id();
		$this->player = User::find($this->id)->player;
    
 		$this->game = Game::where('user_id', $this->id)
            ->where('queue_format', $this->player->queue_format)
            ->where('queue_Bo', $this->player->queue_Bo)
            ->orderBy('created_at','desc')
            ->first();

		$this->oppgame = Game::where('game_id', $this->game->game_id)
            ->where('opponent', $this->id)
            ->first();

        if($won == 1) {
        	$this->winner = $this->id;
        	$this->loser = $this->game->opponent;
        } else {
        	$this->winner = $this->game->opponent;
        	$this->loser = $this->id;
        }

	    $this->game->reported_winner = $this->winner;
    	$this->game->save();

        if(is_null($this->oppgame->reported_winner)) {
        	// Opponent hasn't reported yet
			// If opponent hasn't marked yet, they can't queue, so don't mark the game resolved.

            // STUFF TO DO HERE! INFORM PERSON GAME NOT RESOLVED

        } else {
        	// Make sure opponent has same result
        	if($this->oppgame->reported_winner != $this->winner) {
        		// Different winners! OH NO!!!!
        		// FREAK OUT PLS
        	} else {
            	// Same winner! Now we can mark the game done, mark the winner and increment their glicko
            	$this->game->winner = $this->winner;
        		$this->game->save();

        		$this->oppgame->winner = $this->winner;
        		$this->oppgame->save();

                $update = Game::updateGlicko($this->game->game_id);

        		$this->player->gamed = 0;
    	       	$this->player->save();

        		$this->opp = User::find($this->game->opponent)->player;
        		$this->opp->gamed = 0;
    	       	$this->opp->save();
            }
        }


		return redirect('/dashboard');
	}

}
