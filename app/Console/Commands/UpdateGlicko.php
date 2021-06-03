<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Game;
use App\Player;
use App\Glicko2Player;
use Diegobanos\Glicko2\Rating\Rating;
use Diegobanos\Glicko2\Result\Result;
use Diegobanos\Glicko2\Glicko2;



class UpdateGlicko extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateglicko';

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
//$David = new Glicko2Player();

//$David->Update(); // David did not participate, but must be updated
//$this->info('Player: ' . $David->rating . "!" . $David->rd);

        $players = Player::where('user_id', '>', 0)->get();

        foreach($players as $player)
        {
            $count = Game::where('user_id', $player->user_id)->where('winner', '>', 0)->count();
            $this->info($player->user_id . ": " . $count);
        }

        return 0;
    }
}
