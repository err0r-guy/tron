<?php

namespace App\Providers;

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
        $viewShare['settings'] = \App\Models\Settings::first();
        view()->share($viewShare);


        view()->composer('partials.plans', function($view) {
            $view->with([
                'plans' => \App\Models\Plan::where('status', 1)->get(),
            ]);
        });

    }
}
