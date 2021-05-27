<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('players')->delete();
        
        \DB::table('players')->insert(array (
            0 => 
            array (
	        	'user_id' => 1,
	        	'ptcgo_name' => 'admin',
	        	'rating' => 1500,
	        	'rating_deviation' => 350,
	        	'rating_volatility' => 0.06,
	        	'temp_rating' => 1500,
	        	'last_real_rating' => now(),
	        	'queued' => 0,
	        	'last_queued' => null,
	            'queue_format' => 0,
	            'queue_Bo'=> 1,
	        	'gamed' => 0,
	        	'banned' => 0,
	        	'banned_comment' => "",
                'created_at' => '2017-11-21 16:07:22',
                'updated_at' => '2018-09-22 23:34:02'
            ),
            1 => 
            array (
	        	'user_id' => 2,
	        	'ptcgo_name' => 'bob1',
	        	'rating' => 1500,
	        	'rating_deviation' => 350,
	        	'rating_volatility' => 0.06,
	        	'temp_rating' => 1500,
	        	'last_real_rating' => now(),
	        	'queued' => 123456,
	        	'last_queued' => '2018-09-22 23:34:02',
	            'queue_format' => 0,
	            'queue_Bo'=> 1,
	        	'gamed' => 0,
	        	'banned' => 0,
	        	'banned_comment' => "",
                'created_at' => '2017-11-21 16:07:22',
                'updated_at' => '2018-09-22 23:34:02'
            ),
            2 => 
            array (
	        	'user_id' => 3,
	        	'ptcgo_name' => 'bob2',
	        	'rating' => 1500,
	        	'rating_deviation' => 350,
	        	'rating_volatility' => 0.06,
	        	'temp_rating' => 1500,
	        	'last_real_rating' => now(),
	        	'queued' => 125678,
	        	'last_queued' => '2018-09-22 23:34:02',
	            'queue_format' => 0,
	            'queue_Bo'=> 1,
	        	'gamed' => 0,
	        	'banned' => 0,
	        	'banned_comment' => "",
                'created_at' => '2017-11-21 16:07:22',
                'updated_at' => '2018-09-22 23:34:02'
            ),
            3 => 
            array (
	        	'user_id' => 4,
	        	'ptcgo_name' => 'bob3',
	        	'rating' => 1500,
	        	'rating_deviation' => 350,
	        	'rating_volatility' => 0.06,
	        	'temp_rating' => 1500,
	        	'last_real_rating' => now(),
	        	'queued' => 0,
	        	'last_queued' => null,
	            'queue_format' => 0,
	            'queue_Bo'=> 0,
	        	'gamed' => 0,
	        	'banned' => 0,
	        	'banned_comment' => "",
                'created_at' => '2017-11-21 16:07:22',
                'updated_at' => '2018-09-22 23:34:02'
            ),
            4 => 
            array (
	        	'user_id' => 5,
	        	'ptcgo_name' => 'bob4',
	        	'rating' => 1500,
	        	'rating_deviation' => 350,
	        	'rating_volatility' => 0.06,
	        	'temp_rating' => 1500,
	        	'last_real_rating' => now(),
	        	'queued' => 0,
	        	'last_queued' => null,
	            'queue_format' => 0,
	            'queue_Bo'=> 0,
	        	'gamed' => 0,
	        	'banned' => 0,
	        	'banned_comment' => "",
                'created_at' => '2017-11-21 16:07:22',
                'updated_at' => '2018-09-22 23:34:02'
            ),
            5 => 
            array (
	        	'user_id' => 6,
	        	'ptcgo_name' => 'bob5',
	        	'rating' => 1500,
	        	'rating_deviation' => 350,
	        	'rating_volatility' => 0.06,
	        	'temp_rating' => 1500,
	        	'last_real_rating' => now(),
	        	'queued' => 153736,
	        	'last_queued' => '2018-09-22 23:34:02',
	            'queue_format' => 0,
	            'queue_Bo'=> 1,
	        	'gamed' => 0,
	        	'banned' => 0,
	        	'banned_comment' => "",
                'created_at' => '2017-11-21 16:07:22',
                'updated_at' => '2018-09-22 23:34:02'
            ),
        ));

    }
}
