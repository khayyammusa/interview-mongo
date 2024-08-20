<?php

namespace App\Providers;

use App\Contracts\DistanceCalculatorInterface;
use App\Contracts\PriceCalculatorInterface;
use App\Services\DistanceCalculator;
use App\Services\PriceCalculator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this -> app -> bind( DistanceCalculatorInterface::class, DistanceCalculator::class );
        $this -> app -> bind( PriceCalculatorInterface::class, PriceCalculator::class );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
