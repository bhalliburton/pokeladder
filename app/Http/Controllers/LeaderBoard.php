<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaderBoard extends Controller
{
    //
    public function index()
    {
    	$leaders = \DB::table('players')->select('ptcgo_name', 'rating')->where('rating', '>', 1500)->orderBy('rating','desc')->limit(10)->get()->toArray();
    	return view('leaderboard', compact('leaders'));
    }
}
