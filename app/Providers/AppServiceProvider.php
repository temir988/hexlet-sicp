<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use URL;
use DB;
use Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     */
    public function register(): void
    {
        if (config('logging.log_sql_queries')) {
            DB::listen(function ($query): void {
                    info($query->sql, [
                            'bind' => $query->bindings,
                            'time' => $query->time,
                        ]);
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        Blade::include('components.comments', 'comments');
        Blade::include('components.solutions', 'solutions');
    }
}
