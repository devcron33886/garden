<?php

namespace App\Providers;

use App\Category;
use App\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191); //Solved by increasing StringLength

        Paginator::useBootstrap();

        View::share('defaultSetting', Setting::first());
        View::share('categories', Category::withCount('products')->latest()->get());

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
