<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestTableDataSeeder extends Seeder
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
    			'id' => '7',
    			'name' => 'General',
    		],
    		[
    			'id' => '8',
    			'name' => 'Accutane',
    		],
    		[
    			'id' => '9',
    			'name' => 'Topical Cream',
    		],
    		
    	]);
    }
}
