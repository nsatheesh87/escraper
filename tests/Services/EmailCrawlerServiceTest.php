<?php

namespace Tests\Services;

use App\Scraper\Services\EmailScraper;

class EmailCrawlerServiceTest extends TestCase
{
    /**
     *
     */
    public function testCrawler() {
        $url = 'https://www.w3schools.com/tags/tryit.asp?filename=tryhtml_link_mailto';
        $output = ['someone@example.com', 'someone@example.com'];
        $emailScraper = new EmailScraper($url);
        $this->assertEquals($output, $emailScraper);
    }
}