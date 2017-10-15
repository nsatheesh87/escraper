<?php

namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Scraper\Services\LinkScraper;
use App\Link;
use App\FollowUpLink;
use Illuminate\Support\Facades\Log;

class ScrapEmailJob implements ShouldQueue
{
use InteractsWithQueue, Queueable, SerializesModels;

    protected $linkScraper;
    protected $link;
    /**
     * Create a new job instance.s
     */
    public function __construct(Link $link)
    {
        $this->link = $link;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(LinkScraper $linkScraper)
    {
        Log::info('Scrap follow-up links job process initiated - Url: '.$this->link->url);
       // FollowUpLink::create(['parent_id' => '1', 'url' => 'http://www.google.com']); exit;
       /* $scrapedLinks =  $linkScraper->scrap($this->link->url);
        $formattedLinks = [];
        foreach($scrapedLinks as $sKey => $scrapedLink) {
            $formattedLinks[$sKey]['parent_id']     = $this->link->id;
            $formattedLinks[$sKey]['url']           = $scrapedLink;
            $formattedLinks[$sKey]['created_at' ]   = date('Y-m-d H:i:s');
            $formattedLinks[$sKey]['updated_at']    = date('Y-m-d H:i:s');
        }
        FollowUpLink::insert($formattedLinks); */
        Log::info('Scrap follow-up links job process completed - Url: '. $this->link->url);
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        // Send user notification of failure, etc...
    }
}