<?php

namespace App\Http\Livewire;

use App\User;
use App\Player;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Carbon\Carbon;

class ShowQueue extends Component
{
    private function queueCheck($format, $bo)
    {
        $players = \DB::table('players')
            ->select('id')
            ->where('queued', '>', '0')
            ->where('queue_format', $format)
            ->where('queue_Bo', $bo)
            ->where('gamed', '0')
            ->where('banned', '0')
            ->get()->toArray();

        return count($players);

    }

    private function fourHourCheck($format, $bo)
    {
        $players = \DB::table('queues')
            ->where('created_at', '>', Carbon::now()->subMinutes(240))
            ->where('queue_format',$format)
            ->where('queue_Bo', $bo)
            ->get()->toArray();

        return count($players);

    }

    public function render()
    {

        $id = Auth::id();
        $player = User::find($id)->player;
        $this->rating = User::find($id)->player->rating;

        if($player->queued > 0 || $player->gamed > 0)
        {
            return <<<'blade'
                <div class="relative flex-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-700">
                        This is your PTCGO Dashboard
                    </h3>
                    <p class="text-sm leading-5 text-gray-500 mt">
                        Current rating: {{ $this->rating }}
                    </p>
                </div>

            </div>
            <div class="relative p-5">
    
                        <p>
                        <span class="inline-flex mt-5 rounded-md shadow-sm">
                        <a href="{{ route('viewgame') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50">
                        You are already in a game!</a>
                        </span>
                        </p>
            </div>
            blade;

        } else {

        $this->zeroone = self::queueCheck(0,1);
        $this->fourzeroone = self::fourHourCheck(0,1);
        $this->zerothree = self::queueCheck(0,3);
        $this->fourzerothree = self::fourHourCheck(0,3);
        $this->oneone = self::queueCheck(1,1);
        $this->fouroneone = self::fourHourCheck(1,1);
        $this->onethree = self::queueCheck(1,3);
        $this->fouronethree = self::fourHourCheck(1,3);


        return <<<'blade'
                <div class="relative flex-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-700">
                        This is your PTCGO Dashboard
                    </h3>
                    <p class="text-sm leading-5 text-gray-500 mt">
                        Current rating: {{ $this->rating }}
                    </p>
                </div>

            </div>
            <div class="relative p-5">
    
            <p>
            <div wire:poll>
            <table>
                <tr>
                    <th class="w-1/2"></th>
                    <th class="w-1/4 text-center">Queued Now</th>
                    <th class="w-1/4 text-center">Queued in <br>Last 4 hours</th>
                </tr>
                <tr>
                    <td>
                        <span class="inline-flex mt-5 rounded-md shadow-sm">
                        <a href="{{ route('startgame', ['format'=>0, 'bo'=>1]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50">
                        Play a Standard Format, <br>Best of One Game</a>
                        </span>
                    </td>
                    <td class="text-center">{{ $this->zeroone }}</td>
                    <td class="text-center">{{ $this->fourzeroone }}</td>
                </tr>
                <tr>
                    <td>
                        <span class="inline-flex mt-5 rounded-md shadow-sm">
                        <a href="{{ route('startgame', ['format'=>0, 'bo'=>3]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50">
                        Play a Standard Format, <br>Best of Three Game</a>
                        </span>
                    </td>
                    <td class="text-center">{{ $this->zerothree }}</td>
                    <td class="text-center">{{ $this->fourzerothree }}</td>
                </tr>
                <tr>
                    <td>
                        <span class="inline-flex mt-5 rounded-md shadow-sm">
                        <a href="{{ route('startgame', ['format'=>1, 'bo'=>1]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50">
                        Play an Expanded Format, <br>Best of One Game</a>
                        </span
                    </td>
                    <td class="text-center">{{ $this->oneone }}</td>
                    <td class="text-center">{{ $this->fouroneone }}</td>
                </tr>
                <tr>
                    <td>
                        <span class="inline-flex mt-5 rounded-md shadow-sm">
                        <a href="{{ route('startgame', ['format'=>1, 'bo'=>3]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50">
                        Play an Expanded Format, <br>Best of Three Game</a>
                        </span>
                    </td>
                    <td class="text-center">{{ $this->onethree }}</td>
                    <td class="text-center">{{ $this->fouronethree }}</td>
                </tr>
            </table>
            </div>
            </p>
            </div>
        blade;
        }
    }

    /*
*/
}
