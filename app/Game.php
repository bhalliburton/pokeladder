<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Diegobanos\Glicko2\Rating\Rating;
use Diegobanos\Glicko2\Result\Result;
use Diegobanos\Glicko2\Glicko2;
use App\Player;
use App\Queue;


class Game extends Model
{
    use HasFactory;

    public static function setGlick($rating, $dev, $opp_rating, $opp_dev, $binary) 
    {
            $glicko2 = new Glicko2;

            $rating = new Rating($rating, $dev);

            $results = [
                new Result(new Rating($opp_rating, $opp_dev), $binary), //victory
            ];

            return $newRating = $glicko2->calculateRating($rating, $results);

    }

    public static function updateGlicko($game_id)
    {
        $game = Game::where('game_id', $game_id)->first();
        $oppgame = Game::where('game_id', $game_id)
            ->where('opponent', $game->user_id)->first();
        if($game->winner > 0 && $oppgame->winner > 0) 
        {
            // we have winners for both, we can update!

            if($game->winner == $game->user_id) 
            {
                $winningid = $game->user_id;
                $losingid = $game->opponent;
            } else {
                $losingid = $game->user_id;
                $winningid = $game->opponent;                
            }

            $winning = Player::where('user_id', $winningid)
            ->first();
            $losing = Player::where('user_id', $losingid)
            ->first();

            $winnerwinner = self::setGlick($winning->rating, $winning->rating_deviation, $losing->rating, $losing->rating_deviation, 1);

            $loserloser = self::setGlick($losing->rating, $losing->rating_deviation, $winning->rating, $winning->rating_deviation, 0);

            $winning->rating = $winnerwinner->getRating();
            $winning->rating_deviation = $winnerwinner->getRatingDeviation();
            $winning->rating_volatility = $winnerwinner->getVolatility();
            $winning->save();

            $losing->rating = $loserloser->getRating();
            $losing->rating_deviation = $loserloser->getRatingDeviation();
            $losing->rating_volatility = $loserloser->getVolatility();
            $losing->save();
        }
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function opp()
    {
        return $this->hasOne(User::class, 'id', 'opponent');
    }

    public function rep_winner()
    {
        return $this->hasOne(User::class, 'id', 'reported_winner');
    }

    public function winners()
    {
        return $this->hasOne(User::class, 'id', 'winner');
    }

    public function queue()
    {
        return $this->hasOne(Queue::class, 'queue_id', 'queue_id');
    }

}
