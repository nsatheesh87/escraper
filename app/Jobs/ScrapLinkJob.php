<?php

namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Scraper\Services\LinkScraper;
use App\Task;
use App\Link;
use Illuminate\Support\Facades\Log;

class ScrapLinkJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var
     */
    protected $linkScraper;

    /**
     * @var Task
     */
    protected $task;

    /**
     * ScrapLinkJob constructor.
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * @param LinkScraper $linkScraper
     *
     * Execute the Job
     * @return void
     */
    public function handle(LinkScraper $linkScraper)
    {
        Log::info('Scrap follow-up links job process initiated - Url: '.$this->task->url);
        $scrapedLinks =  $linkScraper->scrap($this->task->url);
        /* Add task link to scrap the email */
        $formattedLinks[0] = ['task_id' => $this->task->id,
                               'url' => $this->task->url,
                               'created_at' => date('Y-m-d H:i:s'),
                               'updated_at'    => date('Y-m-d H:i:s')
                              ];
        foreach($scrapedLinks as $sKey => $scrapedLink) {
            $formattedLinks[$sKey+1]['task_id']     = $this->task->id;
            $formattedLinks[$sKey+1]['url']           = $scrapedLink;
            $formattedLinks[$sKey+1]['created_at' ]   = date('Y-m-d H:i:s');
            $formattedLinks[$sKey+1]['updated_at']    = date('Y-m-d H:i:s');
        }
        Link::insert($formattedLinks);
        Log::info('Scrap follow-up links job process completed - Url: '. $this->task->url);
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