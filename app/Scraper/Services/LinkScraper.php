<?php
// app/Scraper/Services/LinkScraper.php
namespace App\Scraper\Services;

class LinkScraper implements ScrapServiceInterface
{
    /**
     * @var
     */
    protected $url;

    /**
     * @param $url
     * @return bool
     */
    private function isAbsolutePath($url)
    {
        if ((substr($url, 0, 7) == 'http://') || (substr($url, 0, 8) == 'https://')) {
            return true;
        }
        return false;
    }

    /**
     * @param $followupUrl
     * @return bool
     */
    private function isSameDomain($followupUrl)
    {
        if (parse_url($this->url, PHP_URL_HOST) !== parse_url($this->validateUrl($followupUrl), PHP_URL_HOST)) {
            return false;
        }
        return true;
    }

    /**
     * @param $url
     * @return string
     */
    private function validateUrl($url)
    {
        if (!$this->isAbsolutePath($url)) {
            return parse_url($this->url, PHP_URL_SCHEME) . '://' . parse_url($this->url, PHP_URL_HOST) . $url;
        }
        return $url;
    }

    /**
     * @param string $url
     * @return array
     */
    public function scrap($url = '')
    {
        $this->url = $url;
        $input = @file_get_contents($this->url) or die("Could not access file: $this->url");
        $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
        $urlArray[] = $url;

         if (preg_match_all("/$regexp/siU", $input, $matches, PREG_SET_ORDER)) {
             foreach($matches as $match) {
                 if ( $this->isSameDomain($match[2])) {
                     $urlArray[] = $this->validateUrl($match[2]); //link address
                 }
             }
         }
        return array_filter(array_unique($urlArray));
    }
}