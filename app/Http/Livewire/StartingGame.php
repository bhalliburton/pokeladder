<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\User;
use App\Player;
use App\Match;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;


class StartingGame extends Component
{
    use WithFileUploads;

    public $photo;

    public function save()
    {
        $this->validate([
            'photo' => 'image|max:4096',
        ]);

        $filename = $this->photo->store('results');

        $this->id = Auth::id();

        $match = Match::where('user_id', $this->id)
            ->orderBy('created_at','desc')
            ->first();

        $match->winner_file = $filename;
        $match->save();

    }


    public function render()
    {

    	$this->id = Auth::id();
	    $this->player = User::find($this->id)->player;

        $this->match = Match::where('user_id', $this->id)
                ->orderBy('created_at','desc')
                ->first();

        $this->oppmatch = Match::where('match_id', $this->match->match_id)->where('opponent', $this->id)
            ->first();

        if($this->player->matched === 0 && $this->player->queued === 0)
        {
            return <<<'blade'
                <div>
                Go to the dashboard and start a game!
                </div>
            blade;

        }

        if ($this->match !== null && $this->match->accepted == 2 && $this->match->queue->created_at == $this->player->last_queued && $this->player->queued == 0) 
        {
            return <<<'blade'
                <div>
                Sorry, your opponent refused. Return to the dashboard and re-queue.
                </div>
            blade;
        }

        if($this->match->reported_winner > 0 && is_null($this->oppmatch->reported_winner)) 
        {
            return <<<'blade'
                <div>
                Your opponent has not reported a winner. If they don't report a winner in ten minutes, this match will be closed with the winner you selected.
                </div>
            blade;

        }


	    if($this->player->matched === 0) 
        {
            $this->time = strtotime($this->player->last_queued);
            $this->showtime = date('G:i:s', (time() - $this->time));
        } else {
            $this->opp = User::find($this->match->opponent)->player;
            $this->oppmatch = Match::where('user_id', $this->match->opponent)
                ->where('opponent', $this->id)
                ->where('queue_format', $this->player->queue_format)
                ->where('queue_Bo', $this->player->queue_Bo)
                ->orderBy('created_at','desc')
                ->first();
        }

        if ($this->player->queue_Bo == 1) { $this->games = "You will play a single game and record the results of that game here."; } 
        else { $this->games = "You will play up to three games. The first person to win two games will be the winner. You will record the final outcome here."; }

return <<<'blade'
<div>
@if ($this->player->matched === 0)
    <div wire:poll.1000ms>
    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Time in queue: {{ $this->showtime }}</h2>
    @if ($this->player->queue_format === 0)
        <p><h2 class="mt-6 text-3xl font-extrabold text-gray-900">You are waiting for a standard format game.</h2></p>
    @else
        <p><h2 class="mt-6 text-3xl font-extrabold text-gray-900">You are waiting for an expanded format game.</h2></p>
    @endif

    <p class="mt-5 text-base">
    @if ($this->player->queue_Bo === 1)
        This will be a Best of One game format. You will play a single game to determine the winner. Both parties must report the final outcome.
    @else
        This will be a Best of Three game format. You will play games until one person has won two games. Both parties must report the final outcome.
    @endif
    </p>
    <p>
        <span class="inline-flex mt-5 rounded-md shadow-sm">
            <a href="{{ route('cancelgame') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50">
                Remove yourself from the queue
            </a>
        </span>
        </p>
    </div>
@else
    <div>
    <h1 class="mt-6 text-3xl font-extrabold text-gray-900">You Matched!</h1>
    <h2 class="mt-6 text-2xl font-extrabold text-gray-900">{{ $this->player->ptcgo_name}} vs. {{ $this->opp->ptcgo_name }} </h2>
    <h3 class="mt-6 text-2xl font-extrabold text-gray-900">Format: 
        @if ($this->player->queue_format === 0) 
            Standard format - 
        @else 
            Expanded format - 
        @endif
        @if ($this->player->queue_Bo === 1) 
            Best of One
        @else 
            Best of Three
        @endif
        </h3>

    @if ($this->oppmatch->accepted === 1 && $this->match->accepted === 1)
        <div>
        <h2 class="mt-6 text-3xl font-extrabold text-gray-900">It's time to play!</h2>
        <p class="mt-6 text-xl font-extrabold text-gray-900">Send {{ $this->opp->ptcgo_name }} a friend request on PTCGO and/or accept a friend request from them if they send you one first.</p>
        <p class="mt-6 text-xl font-extrabold text-gray-900">{{ $this->games }}</p>
        <p class="mt-6 text-xl font-extrabold text-gray-900">
        If, at the conclusion of your game, you wish to upload proof of the outcome, please do so before submitting the result:
        <form wire:submit.prevent="save">
            <input type="file" wire:model="photo">

            @error('photo') <span class="error">{{ $message }}</span> @enderror

            <span class="inline-flex mt-5 rounded-md shadow-sm"><button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50">Submit</button></span>
        </form>
        </p>
        <p>
            <span class="inline-flex mt-5 rounded-md shadow-sm">
                <a href="{{ route('wongame', 1) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50">
                I won the match.
                </a>
            </span>

            <span class="inline-flex mt-5 rounded-md shadow-sm">
                <a href="{{ route('wongame', 0) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50">
                I lost the match.
                </a>
            </span>
        </p>
        <p class="mt-6 text-m font-extrabold text-gray-900">You will not be allowed to queue up for another game until both parties have reported the final outcome of this game. If one party reports that they have won, but the other party fails to report, after 10 minutes the winner will be determined. There may be future penalties imposed on the loser for failing to report.</p>
        <p class="mt-6 text-m font-extrabold text-gray-900">If you report that you won in error, you may be banned from the service.</p>
        <p class="mt-6 text-xl font-extrabold text-gray-900">You should always feel free to take and/or upload a screenshot showing final disposition of the game.</p>
        <p class="mt-6 text-m font-extrabold text-gray-900">If you feel like your opponent behaved inappropriately in any way, contact bhalliburton@gmail.com to report them.</p>
        </div>

    @else
        @if ($this->oppmatch->accepted === 1)
            <div>
            <h3 class="mt-6 text-2xl font-extrabold text-gray-900">Your opponent has accepted and is ready to play!</h3>
            </div>
        @endif

        @if ($this->match->accepted === 1)
            <p>
            <h3 class="mt-6 text-4xl font-extrabold text-gray-900">You have accepted the challenge. Waiting for your opponent!</h3>
            </p>
        @else
            <p>
            <span class="inline-flex mt-5 rounded-md shadow-sm">
                <a href="{{ route('acceptgame') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50">
                Accept the challenge!
                </a>
            </span>
            <span class="inline-flex mt-5 rounded-md shadow-sm">
                <a href="{{ route('refusegame') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50">
                Refuse to play!
                </a>
            </span>
            </p>
        @endif
    @endif
    </div>
@endif
</div>
blade;
    }
}
