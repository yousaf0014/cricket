<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
       Model::unguard();

        $this->call(CountryListTableSeeder::class);

        $this->call(SecurityRoleTableSeeder::class);

        $this->call(ItemUnitTableSeeder::class);

        $this->call(CurrencyTableSeeder::class);

        $this->call(SalesTypesTableSeeder::class);

        $this->call(ItemTaxTypesTableSeeder::class);

        $this->call(InvoicePaymentTermsTableSeeder::class);

        $this->call(StockCategoryTableSeeder::class);

        $this->call(PaymentTermsTableSeeder::class);

        $this->call(LocationTableSeeder::class);

        $this->call(EmailConfigTableSeeder::class);

        $this->call(PreferenceTableSeeder::class);

        $this->call(EmailTempDetailsTableSeeder::class);

    }
}
