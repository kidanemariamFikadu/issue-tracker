<?php

namespace App\Providers;

use App\Models\IssueReport;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        IssueReport::observe(\App\Observers\IssueReportOberser::class);
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
