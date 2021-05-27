<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Player;
use App\Game;
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
	    $player->gamed = 0;
	    $player->save();

        // Note that he didn't accept
        $game = Game::where('user_id', $id)
            ->where('queue_format', $player->queue_format)
            ->where('queue_Bo', $player->queue_Bo)
            ->orderBy('created_at','desc')
            ->first();

        $game->accepted = 0;
        $game->save();

        // Note in opponent that this guy refused
        $regame = Game::where('game_id', $game->game_id)
            ->where('opponent', $id)
            ->first();

        $regame->accepted = 2;
        $regame->save();

        // Clear opponent to play in another game
	    $replayer = User::find($regame->user_id)->player;
	    $replayer->queued = 0;
	    $replayer->gamed = 0;
	    $replayer->save();

	    return redirect('/dashboard');
	}
}
