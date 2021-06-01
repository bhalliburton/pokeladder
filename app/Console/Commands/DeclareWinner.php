<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Game;
use App\Player;


class DeclareWinner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'declarewinner {gameid} {winneruserid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $gameid = $this->argument('gameid');
        $winner = $this->argument('winneruserid');

        $player = User::find($winner)->player;
    
        $game = Game::where('user_id', $winner)
            ->where('game_id', $gameid)
            ->first();

        $oppgame = Game::where('game_id', $gameid)
            ->where('opponent', $winner)
            ->first();

        $game->reported_winner = $winner;
        $game->winner = $winner;
        $game->save();

        $oppgame->winner = $winner;
        $oppgame->save();

        $update = Game::updateGlicko($game->game_id);

        $player->gamed = 0;
        $player->save();

        $opp = User::find($game->opponent)->player;
        $opp->gamed = 0;
        $opp->save();


        return 0;
    }
}
