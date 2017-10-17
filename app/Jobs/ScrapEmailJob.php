<?php

namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Scraper\Services\LinkScraper;
use App\Link;
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
        $url = "http://compassloft.com/careers/";
        $input = @file_get_contents($url) or die("Could not access file: $url");
        $regexp = "/[a-z0-9]+[_a-z0-9.-]*[a-z0-9]+@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})/i";
        $urlArray = [];
        if(preg_match_all($regexp, $input, $matches, PREG_SET_ORDER)) {
            foreach($matches as $match) {
                $urlArray[] = $match[0];
                // $match[2] = link address
                // $match[3] = link text
            }
            $urlArray = array_unique($urlArray);
        }
        dd($urlArray);

        Log::info('Scrap email address job process initiated - Url: '.$this->link->url);
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
        Log::info('Scrap email address job process completed - Url: '. $this->link->url);
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