<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Vanilo\Category\Contracts\Taxon as TaxonContract;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->app->concord->registerModel(
            \Konekt\User\Contracts\User::class, \App\User::class,
            TaxonContract::class, \App\Product::class,
            TaxonContract::class, \App\Taxon::class
            );
        \Illuminate\Database\Eloquent\Relations\Relation::morphMap([
            'product' => \App\Product::class
        ]);
        $app_settings = DB::table('app_settings')->first();
        View::share('app_settings', $app_settings);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
