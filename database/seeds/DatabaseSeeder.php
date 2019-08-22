<?php

//import my miscellaneous functions
require(storage_path('misc/my_functions.php'));

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProductsTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(StaffsTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
    }
}

