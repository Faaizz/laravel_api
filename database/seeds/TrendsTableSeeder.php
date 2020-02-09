<?php

use Illuminate\Database\Seeder;

class TrendsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Trend::class, 10)->create();
    }
}