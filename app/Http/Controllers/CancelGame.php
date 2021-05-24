<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Player;
use Illuminate\Support\Facades\Auth;

class CancelGame extends Controller
{
    //
    public function index()
    {
    	$id = Auth::id();
	    $player = User::find($id)->player;
	    $player->queued = 0;
	    $player->matched = 0;
	    $player->save();

	    return redirect('/dashboard');
	}
}
