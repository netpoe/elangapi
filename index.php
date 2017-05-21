<?php 

if (file_exists('vendor/autoload.php')) {
    include 'vendor/autoload.php';
}

$app = new Elang\Application;

$lang = 'es_MX';
$scraperMapKey = 'words';
$scraper = $app->getScraper($lang, $scraperMapKey);

$scraper->createWord('John');

// $scraper = new Elang\Scraper\es_MX\VerbsScraper('es_MX');
// $scraper
//     ->scrape()
//     ->removeDuplicates();