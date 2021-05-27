<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Player;
use Carbon\Carbon;

class RegisterController extends \Wave\Http\Controllers\Auth\RegisterController
{
    public function create(array $data)
    {
        $role = \TCG\Voyager\Models\Role::where('name', '=', config('voyager.user.default_role'))->first();

        $verification_code = NULL;
        $verified = 1;

        if(setting('auth.verify_email', false)){
            $verification_code = str_random(30);
            $verified = 0;
        }

        if(isset($data['username']) && !empty($data['username'])){
            $username = $data['username'];
        } elseif(isset($data['name']) && !empty($data['name'])) {
            $username = str_slug($data['name']);
        } else {
            $username = $this->getUniqueUsernameFromEmail($data['email']);
        }

        $username_original = $username;
        $counter = 1;

        while(User::where('username', '=', $username)->first()){
            $username = $username_original . (string)$counter;
            $counter += 1;
        }

        $trial_days = setting('billing.trial_days', 14);
        $trial_ends_at = null;
        // if trial days is not zero we will set trial_ends_at to ending date
        if(intval($trial_days) > 0){
            $trial_ends_at = now()->addDays(setting('billing.trial_days', 14));
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $username,
            'password' => bcrypt($data['password']),
            'role_id' => $role->id,
            'verification_code' => $verification_code,
            'verified' => $verified,
            'trial_ends_at' => $trial_ends_at
        ]);

        $player = Player::create([
        	'user_id' => $user->id,
        	'ptcgo_name' => $user->username,
        	'rating' => 1500,
        	'rating_deviation' => 350,
        	'rating_volatility' => 0.06,
        	'temp_rating' => 1500,
        	'last_real_rating' => now(),
        	'queued' => 0,
            'queue_format' => 0,
            'queue_Bo'=> 0,
        	'gamed' => 0,
        	'banned' => 0,
        	'banned_comment' => ""
        ]);

        if(setting('auth.verify_email', false)){
            $this->sendVerificationEmail($user);
        }

        return $user;
    }

}
