<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\ServiceProvider;
use Konekt\User\Contracts\User;
use Vanilo\Category\Contracts\Taxon as TaxonContract;
use Vanilo\Cart\Contracts\Cart as CartContract;
use Illuminate\Support\Facades\View;
use App\Taxon;
use Vanilo\Category\Models\Taxonomy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param UrlGenerator $url
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        Schema::defaultStringLength(191);

        $this->app->concord->registerModel(User::class, \App\User::class);
        $this->app->concord->registerModel(CartContract::class, \App\Cart::class);
//        $this->app->concord->registerModel(TaxonContract::class, \App\Product::class);
        $this->app->concord->registerModel(TaxonContract::class, \App\Taxon::class);

        \Illuminate\Database\Eloquent\Relations\Relation::morphMap([
            'product' => \App\Product::class
        ]);

        if(config('app.env') === 'production') {
            $url->forceScheme('https');
        }


        $app_settings = DB::table('app_settings')->first();
        $all_categories = Taxon::all();
        $brands = Taxonomy::all();
        View::share('app_settings', $app_settings);
        View::share('all_categories', $all_categories);
        View::share('brands', $brands);
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
