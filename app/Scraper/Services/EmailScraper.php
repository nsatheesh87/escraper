<?php
// app/Scraper/Services/LinkScraper.php
namespace App\Scraper\Services;

class EmailScraper implements ScrapServiceInterface
{
    protected $url;

    public function scrap($url = '')
    {
        $this->url = $url;
        $input = @file_get_contents($this->url) or die("Could not access file: $this->url");
        $regexp = "/[A-Za-z0-9_-]+@[A-Za-z0-9_-]+\.([A-Za-z0-9_-][A-Za-z0-9_]+)/";
        $emailArray = [];

        if(preg_match_all($regexp, $input, $matches, PREG_SET_ORDER)) {
            foreach($matches as $match) {
                $emailArray[] = $match[0];
            }
        }
        return array_unique($emailArray);
    }
}