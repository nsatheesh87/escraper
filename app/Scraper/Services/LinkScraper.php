<?php
// app/Scraper/Services/LinkScraper.php
namespace App\Scraper\Services;

class LinkScraper implements ScrapServiceInterface
{
    protected $url;

    public function __construct()
    {

    }

    private function isAbsolutePath($url)
    {
        $pattern = "/^(?:ftp|https?|feed):\/\/(?:(?:(?:[\w\.\-\+!$&'\(\)*\+,;=]|%[0-9a-f]{2})+:)*
        (?:[\w\.\-\+%!$&'\(\)*\+,;=]|%[0-9a-f]{2})+@)?(?:
        (?:[a-z0-9\-\.]|%[0-9a-f]{2})+|(?:\[(?:[0-9a-f]{0,4}:)*(?:[0-9a-f]{0,4})\]))(?::[0-9]+)?(?:[\/|\?]
        (?:[\w#!:\.\?\+=&@$'~*,;\/\(\)\[\]\-]|%[0-9a-f]{2})*)?$/xi";

        return (bool) preg_match($pattern, $url);
    }

    private function isSameDomain($url, $followupUrl)
    {
        if ($this->isAbsolutePath($url)) {
            if (parse_url($url, PHP_URL_HOST) !== parse_url($followupUrl, PHP_URL_HOST)) {
                return false;
            }
        }
        return true;
    }
    public function scrap($url = '')
    {
        $this->url = $url;
        $url = "http://www.compasslist.com";
        $input = @file_get_contents($url) or die("Could not access file: $url");
        $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
        $urlArray = [];

         if(preg_match_all("/$regexp/siU", $input, $matches, PREG_SET_ORDER)) {
             foreach($matches as $match) {
                 if(( $this->isSameDomain($url,  $match[2])) && ($url !== $match[2])) {
                     $urlArray[] = $match[2]; //link address
                 }
             }
         }
        return array_unique($urlArray);
    }
}