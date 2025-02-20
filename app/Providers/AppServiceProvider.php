<?php

namespace App\Providers;

use App\Models\Inquiry;
use App\Observers\ContactObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\In;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
        Inquiry::observe(ContactObserver::class);
        $active_lang = LaravelLocalization::getSupportedLocales();
        View::share('active_lang',$active_lang);
    }
}
