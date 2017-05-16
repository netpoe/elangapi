<?php 

if (file_exists('vendor/autoload.php')) {
    include 'vendor/autoload.php';
}

use Vinelab\NeoEloquent\Connection;

$connections = require(__DIR__ . '/config/database.php');
$neo4j = $connections['connections']['neo4j'];
$connection = new Connection($neo4j);

try {
    $connection->createConnection();
} catch (\Exception $e) {
    error_log($e->getMessage());
    die();
}

// $scraper = new Elang\Library\Scraper\es_MX\VerbsScraper('es_MX');
// $scraper
//     ->scrape()
//     ->removeDuplicates();