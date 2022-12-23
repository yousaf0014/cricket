<?php

use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$currency = [
            'name' => 'USD',
            'symbol' => '$',
        ];
        DB::table('currency')->delete();
		DB::table('currency')->insert($currency);
    }
}