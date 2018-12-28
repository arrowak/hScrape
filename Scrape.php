<?php
/**
 * Created by PhpStorm.
 * User: arun
 * Date: 2018-12-28
 * Time: 11:06
 */

class Scrape
{
    public function getWebsiteContent()
    {
        $url = "https://hiverhq.com";
        $webContent = file_get_contents($url);
        file_put_contents("hiver.html", $this->clean($webContent));
    }

    private function clean($string)
    {
        $string = strip_tags($string);
        $string = preg_replace('/[^A-Za-z0-9\- ]/', '', $string);
        return preg_replace('/\n/', ' ', $string);
    }

}


$s = new Scrape();
//$s->getWebsiteContent();
$fileContent = file_get_contents("hiver.html");
$i = 0;
$words = explode(' ', $fileContent);
$countedWords = array_count_values($words);
arsort($countedWords);
unset($countedWords['']);
print_r(array_slice($countedWords, 0, 5, true));
