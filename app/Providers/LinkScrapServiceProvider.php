<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Scraper\Services\LinkScraper;

class LinkScrapServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Scraper\Services\LinkScraper', function ($app) {
            return new LinkScraper();
        });
    }
}