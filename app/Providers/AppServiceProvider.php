<?php

namespace App\Providers;

use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::defaultStringLength(191);

        // SET BRAND NAME
        View::share('brand_name', 'Bada');
        View::share('copyright_year', Carbon::now()->isoFormat('YYYY'));
        View::share('powered_by', 'Codecreek Inc.');
    }
}
