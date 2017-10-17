<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as Request;
use App\Scraper\Services\LinkScraper;
use App\Scraper\Services\EmailScraper;
use App\Task as Task;
use App\Link as Link;
use App\Jobs\ScrapLinkJob;
use App\Jobs\ScrapEmailJob;
use Validator;
use DB;

class TaskController extends Controller
{
    protected $status;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->status = ['0' => 'Waiting', '1' => 'Processing', '2' => 'completed'];
    }

    public function list()
    {
        $tasks = Task::get();

        foreach($tasks as $tKey => $task) {
            $tasks[$tKey]['status'] = $this->status[$task->status];
        }

        return response()->json($tasks);

    }
    private function crawledEmails($taskId)
    {
        $data = DB::table('crawl_links')->where('crawl_links.task_id', '=', $taskId)
            ->leftJoin('crawled_emails','crawl_links.id', '=', 'crawled_emails.url_id')
            ->select('crawl_links.url', 'crawled_emails.email')->get();
        $response = [];
        foreach($data as $dKey => $dValue) {
            $response[$dValue->url][] = $dValue->email;
        }

        return $response;
    }

    public function show($id = '')
    {
        if(!empty($id)) {
            $task = Task::where('id', '=', $id)->first();
            $response = [];
            if($task) {
                $response['jobId'] = $task->id;
                $response['Job URL'] = $task->url;
                $response['status']  = $this->status[$task->status];
                $response['Created At'] = $task->created_at;
                $response['Updated At'] = $task->updated_at;

                if($task->status == '2') {
                    $response['data'] = $this->crawledEmails($task->id);
                }
            }
            return response()->json($response);
        }
        return response()->json('job_id parameter is missing or invalid');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url'
        ]);

        $task = Task::create(['url' => $request->url, 'status' => '1']);
        $job = (new ScrapLinkJob($task))->onQueue('LinkQueue');
        dispatch($job);
        return response()->json($task);
    }

    public function test()
    {
        $taskId = 4;
        $pendingLinks = Link::whereIn('status', ['0,1'])->where('task_id', '=', $taskId)->count();
       // dd($pendingLinks);
        if($pendingLinks == 0) {
            Task::where('id', $taskId)->update(['status' => '2']);
        }
    }
}
