<?php 

if (file_exists('vendor/autoload.php')) {
    include 'vendor/autoload.php';
}

$app = new Elang\Application;
$app->run();

$lang = 'es_MX';
$scraperMapKey = 'words';
$scraper = $app->getScraper($lang, $scraperMapKey);

$scraper->createWord();

// $scraper = new Elang\Scraper\es_MX\VerbsScraper('es_MX');
// $scraper
//     ->scrape()
//     ->removeDuplicates();