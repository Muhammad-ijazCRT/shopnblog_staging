<?php

namespace App\Providers;

use App\Models\PaymentGateways;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
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
        //

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        
    //    Retrieve the data and share it with all views
       $paypal_payment = PaymentGateways::where('enabled', '1')
       ->where('name', 'PayPal')->first();

        // Share the data with all views
        view()->share('paypal_payment', $paypal_payment);


        Blade::withoutDoubleEncoding();
        Paginator::useBootstrap();
    }
}
