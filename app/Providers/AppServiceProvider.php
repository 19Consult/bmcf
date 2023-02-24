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
        $this->app->singleton('roleIdMD5_register', function () {
            $roleIdMD5_register = [
                1 => md5("Owner"),
                2 => md5("Investor"),
            ];
            return $roleIdMD5_register;
        });
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
