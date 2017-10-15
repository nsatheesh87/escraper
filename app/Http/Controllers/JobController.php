<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as Request;
use App\Scraper\Services\LinkScraper;
use App\Link as Link;
use App\Jobs\ScrapLinkJob;
use Validator;

class JobController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function show($id = '', Request $request)
    {

    }

    public function scrapLinks(LinkScraper $linkScraper)
    {
        $links = $linkScraper->scrap();
        dd($links);
        /* $url = "http://www.compasslist.com";
        $input = @file_get_contents($url) or die("Could not access file: $url");
        $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>"; */
        $urlArray = [];
       /* if(preg_match_all("/$regexp/siU", $input, $matches, PREG_SET_ORDER)) {
            foreach($matches as $match) {
                $urlArray[] = $match[2];
                // $match[2] = link address
                // $match[3] = link text
            }
        } */

        dd($urlArray);
    }
    public function create(Request $request)
    {
        //$link = Link::create($request->all());
        $link = Link::find(1);
        dispatch(new ScrapLinkJob($link));

        /* $this->validate($request, [
            'url' => 'required|url|unique:links'
        ]);


        $link = Link::create($request->all());

        if ($link) {
            dispatch(new ScrapLinkJob($link));
        }
        return response()->json($link);
        */
    }

    //
}
