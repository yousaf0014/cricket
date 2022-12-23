<?php

use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$location = [
            'loc_code' => 'PL',
            'location_name' => 'Primary Location',
            'delivery_address' => 'Primary Location',
            'contact' => 'Primary Location',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        DB::table('location')->delete();
		DB::table('location')->insert($location);
    }
}