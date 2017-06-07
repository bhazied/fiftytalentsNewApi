<?php

namespace App\Providers;

use App\Repositories\Contracts\IRepository;
use App\Repositories\CountryRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        if(! array_key_exists($request->segment(1), config('translatable.locales'))){
            $this->app->setLocale(config('fallback_locale'));
        }
        $this->app->setLocale($request->segment(1));
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
