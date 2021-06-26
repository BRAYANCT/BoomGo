<?php

namespace App\Providers;

use App\Observers\ProductObserver;
use App\Product;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        //Tamaño por defecto de metodo string migracion
        Schema::defaultStringLength(191);


        try {
            \DB::statement("SET lc_time_names = 'es_PE'");
        } catch (\Exception $e) {
            report($e);
        }

        Paginator::defaultView('vendor.pagination.custom-pagination');


        Product::observe(ProductObserver::class);

//        $shoppingCartCookie = \Cookie::get('shopping-cart-boom-go');
//        Log::debug("shoppingCartCookie:".$shoppingCartCookie);

    }
}
