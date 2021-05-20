<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class FrontStatusTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('front_status')->insert([
    		[
    			'status' => 'Default prescription to MD',
    		],
    		[
    			'status' => 'Awaiting MD assigned',
    		],
    		[
    			'status' => 'Clinician Assigned',
    		],
    		[
    			'status' => 'Call  with MD for accutane',
    		],
    		[
    			'status' => 'Consultation completed',
    		],
    		[
    			'status' => 'Prerequisites [action items] ',
    		],
    		[
    			'status' => 'Awaiting Follow UP',
    		],
    		[
    			'status' => 'Awaiting prescription',
    		],
    		[
    			'status' => 'Completed',
    		],
    		[
    			'status' => 'Dosespot confirmed',
    		],
    		[
    			'status' => 'Curexa-Awaiting shipments',
    		],
    		[
    			'status' => 'Local pharmacy–Ready for pickup',
    		]

    	]);
    }
}
