<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Game;
use App\Player;
use Illuminate\Support\Facades\Auth;

class RunGamemaking extends Command
{
    /**
    queue theory

    - rating-rating = Some small number
    - 180-seconds that have elapsed since queue = some small number
    - Number of games they have played - number of games played = Some small number
    - <400 = game
    */
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:gamemaking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the gamemaking queue!';

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
        $games = Game::where('reported_winner', null)->where('winner', null)->where('accepted', 1)->get();

        foreach($games as $game) 
        {
            // Check if the inverse has a reported_winner and if the updated_date is > 10m
            $oppgame = Game::where('game_id', $game->game_id)->where('opponent', $game->user_id)->first();

            if($oppgame->reported_winner > 0 && abs(strtotime(now())-strtotime($oppgame->updated_at)) > 600) 
            {
                // Have a function for setting a winner, cleaning up queue, cleaning up ratings.
                $thatgame = Game::find($oppgame->id);
                $thatgame->winner = $oppgame->reported_winner;
                $thatgame->save();

                $thisgame = Game::find($game->id);
                $thisgame->winner = $oppgame->reported_winner;
                $thisgame->save();

                $player = User::find($game->user_id)->player;
                $opp = User::find($game->opponent)->player;

                $player->gamed = 0;
                $player->save();

                $opp->gamed = 0;
                $opp->save();

                $update = Game::updateGlicko($game->game_id);
            }
        }
    }

    private function gamemaking($format, $bo)
    {

        $players = \DB::table('players')
            ->select('id', 'user_id', 'rating', 'rating_deviation', 'queued', 'last_queued')
            ->where('queued','>','0')
            ->where('queue_format','=',$format)
            ->where('queue_Bo', "=", $bo)
            ->where('gamed','=','0')
            ->where('banned','=','0')
            ->orderBy('rating', 'desc')
            ->get()->toArray();

        // So we have a list of players - start with 1st player (highest rated) and try to make a game bc theoretically, lowest rated players are easier to game

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
                // 5 most recent games
                $priorgames = \DB::table('games')
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

                //If we have a game, note it in the game table and update the players table
                if($score <= 200) // 200 is a random number.
                {

                    $game = mt_rand();

                    \DB::table('games')->insert([
                        'user_id' => $first->user_id,
                        'opponent' => $player->user_id,
                        'game_id' => $game,
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
                    \DB::table('games')->insert([
                        'user_id' => $player->user_id,
                        'opponent' => $first->user_id,
                        'game_id' => $game,
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
                        ->update(['gamed' => 1, 'queued' => 0]);
                    $gamed = \DB::table('players')
                        ->where('id', $first->id)
                        ->update(['gamed' => 1, 'queued' => 0]);

                    //if we have a game or don't have a game, remove that player from the queue
                    // and remove the player they are gamed against from the queue
                    //(remove the player they gamed against first to maintain array numbering)

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
        self::gamemaking(0,1); // run gamemaking for standard, Bo1
        self::gamemaking(1,1); // run gamemaking for expanded, Bo1
        self::gamemaking(0,3); // run gamemaking for standard, Bo3
        self::gamemaking(1,3); // run gamemaking for expanded, Bo3
        self::resolveold();// Resolve over 10 minutes
        return 0;
    }

}
