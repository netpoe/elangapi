<?php 

namespace Elang;

use Vinelab\NeoEloquent\Connection;

class Application
{
    protected $connection;

    public function run()
    {
        $this->connect();

        return $this;
    }

    public function connect()
    {
        $databaseConfig = dirname(__DIR__, 1) . '/config/database.php';
        $connections = require($databaseConfig);
        $neo4j = $connections['connections']['neo4j'];

        try {
            $this->connection = new Connection($neo4j);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            die();
        }

        return $this;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getScraper(String $lang, String $scraperMapKey)
    {
        $scraper = ucwords($scraperMapKey) . 'Scraper';
        $className = "Elang\Scraper\\{$lang}\\{$scraper}";

        return new $className($this, $lang);
    }
}