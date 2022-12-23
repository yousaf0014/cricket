<?php

use Illuminate\Database\Seeder;

class StockCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$stockCategory = [
            'description' => 'Default Category',
            'dflt_units' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        DB::table('stock_category')->delete();
		DB::table('stock_category')->insert($stockCategory);
    }
}