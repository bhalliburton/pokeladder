<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Match;
use Illuminate\Support\Facades\Auth;

class ConflictingMatches extends Controller
{
    //
    public function index()
    {
    	$matches = \DB::table('matches')->select('user_id', 'opponent', 'accepted', 'reported_winner', 'winner_file', 'created_at', 'match_id')->where('winner', null)->orderBy('created_at','desc')->get()->toArray();
    	return view('conflictingmatches', compact('matches'));
    }

}
