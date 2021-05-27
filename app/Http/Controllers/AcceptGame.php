<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Game;
use Illuminate\Support\Facades\Auth;

class AcceptGame extends Controller
{
    //
    public function index()
    {
    	$id = Auth::id();

        $game = Game::where('user_id', $id)
            ->orderBy('created_at','desc')
            ->first();

        $game->accepted = 1;
        $game->save();

		// if one person refuses, notify other people of refusal - don’t let them refuse or accept. If one person accepts, notify other person. If person accepted and other refuses, deal with it appropriately.

	    return redirect('/viewgame');
	}

}
