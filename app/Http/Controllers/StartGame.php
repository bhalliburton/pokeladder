<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Player;
use App\Match;
use Illuminate\Support\Facades\Auth;

class StartGame extends Controller
{
    //
    public function index($format, $bo)
    {

	    $id = Auth::id();
	    $player = User::find($id)->player;
    	
        $match = Match::where('user_id', $id)
                ->orderBy('created_at','desc')
                ->first();

        if (is_null($format) && is_null($bo) && $match !== null && $match->accepted == 2 && $match->queue->created_at == $player->last_queued && $player->queued == 0)
        {
            return view('startgame');
        }

        if($player->queued == 0) 
        {
            $player->queued = mt_rand();
        	$player->queue_format = $format;
        	$player->queue_Bo = $bo;
    	    $player->last_queued = now();
    	    $player->save();

    	   \DB::table('queues')->insert([
   	    		'user_id' => $id,
            	'rating' => $player->rating,
    		    'rating_deviation' => $player->rating_deviation,
                'queue_id' => $player->queued,
	    	    'queue_format' => $format,
    		    'queue_Bo' => $bo,
        	    'created_at' => now(),
                'updated_at' => now()
		  ]);
        }

	    return view('startgame');
	}

	public function view()
	{
    	return view('startgame');		
	}
}
