<?php

namespace App\Providers;

use App\Language;
use App\Service\ParseSortFromCurrentUrl;
use App\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Enable query logging
        DB::enableQueryLog();

        DB::listen(function ($query) {
            /*print_r($query->sql);
            print_r($query->bindings);
            print_r($query->time);*/
        });

        Validator::extend('passcheck', function ($attribute, $value, $parameters) {
            return Hash::check($value, Auth::user()->getAuthPassword());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }*/

        // Load setting
        $this->app->singleton('Setting', function ($app) {
            return Setting::find(config('app.setting_id'));
        });

        // Load setting
        $this->app->singleton('Language', function ($app) {
            return Language::where('is_default', true)->first();
        });

        $this->app->singleton('ParseSortFromCurrentUrl', function ($app) {
            return new ParseSortFromCurrentUrl();
        });
    }
}
