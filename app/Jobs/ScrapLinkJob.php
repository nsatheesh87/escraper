<?php

namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScrapLinkJob implements ShouldQueue
{
use InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.s
     */
    public function __construct()
    {
//
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Request Cycle with Queues Begins");
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