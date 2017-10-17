<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Scraper\Services\EmailScraper;
use App\Link;
use App\Task;
use App\Email;
use Illuminate\Support\Facades\Log;

class EmailCrawl extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'email:crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command crawl email  using email crawl service';

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'email:crawl';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(EmailScraper $emailScraper)
    {
        $processingLink = Link::where('status', '=', '0')->first();

        if($processingLink) {
            Log::info('Scrap email job process initiated - Url: '.$processingLink->url);

            $processingLink->status = '1';
            $processingLink->save();

            $scrapedEmails = $emailScraper->scrap($processingLink->url);
            $formattedEmail = [];
            if(count($scrapedEmails > 0)) {
                foreach($scrapedEmails as $eKey => $email) {
                    $formattedEmail[$eKey]['url_id'] = $processingLink->id;
                    $formattedEmail[$eKey]['email'] = $email;
                    $formattedEmail[$eKey]['created_at' ]   = date('Y-m-d H:i:s');
                    $formattedEmail[$eKey]['updated_at']    = date('Y-m-d H:i:s');
                }
                Email::insert($formattedEmail);
            }
            $processingLink->status = '2';
            $processingLink->save();

            $this->processTaskStatus($processingLink->task_id);
            Log::info('Scrap email job process completed - Url: '.$processingLink->url);
        }

    }

    /**
     * @param $taskId
     */
    private function processTaskStatus($taskId)
    {
        Log::info('Process task status: '. $taskId);
        $pendingLinks = Link::whereIn('status', ['0,1'])->where('task_id', '=', $taskId)->count();
        if($pendingLinks == 0) {
            Task::where('id', $taskId)->update(['status' => '2']);
        }
    }
}