<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class QueueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('queues')->delete();
        
        \DB::table('queues')->insert(array (
            0 => 
            array (
	        	'queue_id' => 123456,
	        	'user_id' => 2,
	        	'rating' => 1500,
	        	'rating_deviation' => 350,
	            'queue_format' => 0,
	            'queue_Bo'=> 1,
                'created_at' => '2018-09-22 23:34:02',
                'updated_at' => '2018-09-22 23:34:02'
            ),
            1 => 
            array (
	        	'queue_id' => 125678,
	        	'user_id' => 3,
	        	'rating' => 1500,
	        	'rating_deviation' => 350,
	            'queue_format' => 0,
	            'queue_Bo'=> 1,
                'created_at' => '2018-09-22 23:34:02',
                'updated_at' => '2018-09-22 23:34:02'
            ),
            2 => 
            array (
	        	'queue_id' => 153736,
	        	'user_id' => 6,
	        	'rating' => 1500,
	        	'rating_deviation' => 350,
	            'queue_format' => 0,
	            'queue_Bo'=> 1,
                'created_at' => '2018-09-22 23:34:02',
                'updated_at' => '2018-09-22 23:34:02'
            ),
        ));

    }
}
