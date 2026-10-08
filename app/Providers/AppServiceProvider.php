<?php

namespace App\Providers;

use App\Support\Navigation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Navigation::class);
    }

    public function boot(): void
    {
        //
    }
}
