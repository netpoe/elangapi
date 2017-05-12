<?php 

if (file_exists('vendor/autoload.php')) {
    include 'vendor/autoload.php';
}

$scraper = new Elang\Library\Scraper\es_MX\VerbsScraper('es_MX');
$scraper
    ->scrape()
    ->removeDuplicates();