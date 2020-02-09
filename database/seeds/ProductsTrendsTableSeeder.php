<?php

use Illuminate\Database\Seeder;

class ProductsTrendsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\ProductTrend::class, 100)->create();
    }
}