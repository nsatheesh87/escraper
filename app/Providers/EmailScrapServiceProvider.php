<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Scraper\Services;

class EmailScrapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Scraper\Services\ScrapServiceInterface', function ($app) {
            return new Services\EmailScraper();
        });
    }
}