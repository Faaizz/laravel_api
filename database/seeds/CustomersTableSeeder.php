<?php

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Insert test data into customers database
     * 
     * @return void
     */
    public function run()
    {
        factory(App\Customer::class, 50)->create();
    }
}
