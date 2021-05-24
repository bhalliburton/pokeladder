<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Match;
use App\Player;
use Illuminate\Support\Facades\Auth;

class RunMatchmaking extends Command
{
    /**
    queue theory

    - rating-rating = Some small number
    - 180-seconds that have elapsed since queue = some small number
    - Number of games they have played - number of games played = Some small number
    - <400 = match
    */
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:matchmaking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the matchmaking queue!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function resolveold()
    {
        $matches = Match::where('reported_winner', null)->where('winner', null)->where('accepted', 1)->get();

        foreach($matches as $match) 
        {
            // Check if the inverse has a reported_winner and if the updated_date is > 10m

            $oppmatch = Match::where('match_id', $match->match_id)->where('opponent', $match->user_id)->first();

            if($oppmatch->reported_winner > 0 && abs(strtotime(now())-strtotime($oppmatch->updated_at)) > 600) 
            {
                // Have a function for setting a winner, cleaning up queue, cleaning up ratings.
                $thatmatch = Match::find($oppmatch->id);
                $thatmatch->winner = $oppmatch->reported_winner;
                $thatmatch->save();

                $thismatch = Match::find($match->id);
                $thismatch->winner = $oppmatch->reported_winner;
                $thismatch->save();

                $player = User::find($match->user_id)->player;
                $opp = User::find($match->opponent)->player;

                $player->matched = 0;
                $player->save();

                $opp->matched = 0;
                $opp->save();

                $update = Match::updateGlicko($match->match_id);
            }
        }
    }

    private function matchmaking($format, $bo)
    {
        $players = \DB::table('players')
            ->select('id', 'user_id', 'rating', 'rating_deviation', 'queued', 'last_queued')
            ->where('queued','>','0')
            ->where('queue_format','=',$format)
            ->where('queue_Bo', "=", $bo)
            ->where('matched','=','0')
            ->where('banned','=','0')
            ->orderBy('rating', 'desc')
            ->get()->toArray();

        // So we have a list of players - start with 1st player (highest rated) and try to make a match bc theoretically, lowest rated players are easier to match

        // Might want to change this to "->inRandomOrder()"

        // Don't bother with queue if only one person in queue.
        $queue_length = count($players);

        while($queue_length>1)
        {
            //start on the 0th player, check them vs. other players
            
            $first = array_shift($players);

            foreach($players as $key => $player)
            {
                $score = 0;

                //Compare player[0] to the next player[$i] to see if they should play

                // See if they played before
                // 5 most recent matches
                $priorgames = \DB::table('matches')
                    ->select('opponent')
                    ->where('user_id', $first->user_id)
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get()->toArray();

                if(in_array(array(['opponent'],$player->user_id), $priorgames)) $score += 300;


                if((($first->rating - (2*$first->rating_deviation))<=($player->rating + (2*$player->rating_deviation))) && (($first->rating + (2*$first->rating_deviation)) >= ($player->rating - (2*$player->rating_deviation)))) 
                {
                    $score +=0; // Their scores intersect
                } else {
                    $score += abs(($first->rating - (2*$first->rating_deviation)) - ($player->rating + (2*$player->rating_deviation))); // add gap between intersection to score;
                }

                $score -= abs(strtotime(now())-strtotime($first->last_queued));

                $score -= abs(strtotime(now())-strtotime($player->last_queued));

                //If we have a match, note it in the match table and update the players table
                if($score <= 200) // 200 is a random number.
                {

                    $match = mt_rand();

                    \DB::table('matches')->insert([
                        'user_id' => $first->id,
                        'opponent' => $player->id,
                        'match_id' => $match,
                        'queue_id' => $first->queued,
                        'queue_format' => $format,
                        'queue_Bo' => $bo,
                        'rating' => $first->rating,
                        'rating_deviation' => $first->rating_deviation,
                        'opp_rating' => $player->rating,
                        'opp_rating_deviation' => $player->rating_deviation,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    \DB::table('matches')->insert([
                        'user_id' => $player->id,
                        'opponent' => $first->id,
                        'match_id' => $match,
                        'queue_id' => $player->queued,
                        'queue_format' => $format,
                        'queue_Bo' => $bo,
                        'rating' => $player->rating,
                        'rating_deviation' => $player->rating_deviation,
                        'opp_rating' => $first->rating,
                        'opp_rating_deviation' => $first->rating_deviation,
                        'created_at' => now(),
                        'updated_at' => now()

                    ]);

                    $opponent = \DB::table('players')
                        ->where('id', $player->id)
                        ->update(['matched' => 1, 'queued' => 0]);
                    $matched = \DB::table('players')
                        ->where('id', $first->id)
                        ->update(['matched' => 1, 'queued' => 0]);

                    //if we have a match or don't have a match, remove that player from the queue
                    // and remove the player they are matched against from the queue
                    //(remove the player they matched against first to maintain array numbering)

                    unset($players[$key]);
                    break;
                }
            
            }

            // We went through every player, so now we toss this guy regardless

            // reset queue length
            $queue_length = count($players);            
        }
        if($queue_length<2) return;
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        self::matchmaking(0,1); // run matchmaking for standard, Bo1
        self::matchmaking(1,1); // run matchmaking for expanded, Bo1
        self::matchmaking(0,3); // run matchmaking for standard, Bo3
        self::matchmaking(1,3); // run matchmaking for expanded, Bo3
        self::resolveold();// Resolve over 10 minutes
        return 0;
    }

}
