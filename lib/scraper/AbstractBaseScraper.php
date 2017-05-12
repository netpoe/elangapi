<?php 

namespace Elang\Library\Scraper;

abstract class AbstractBaseScraper {

    public $hostname = '';

    public $path = '';

    public $directory = '';

    public $lang = '';

    public $response = '';

    public $body = '';

    public $index = '';

    public $data = [];

    abstract public function scrape();

    public function createJsonFile(String $content)
    {
        $file = fopen($this->file, 'w');
        fwrite($file, $content);
        fclose($file);

        return $this;
    }

    public function onFile()
    {
        $this->file = "{$this->directory}/{$this->index}.json";

        return $this;
    }

    public function combineJson()
    {   
        if (!file_exists($this->file)) {
            $this->createJsonFile('[]');
        }

        $data = file_get_contents($this->file);

        $tempArray = json_decode($data, true);

        $content = array_merge($tempArray, $this->data);

        $jsonData = json_encode($content);

        $this->data = $jsonData;
        
        return $this;
    }

    public function clean()
    {
        $data = file_get_contents($this->file);
        
        $content = json_decode($data, true);
        
        $newContent = array_unique($content);

        $jsonData = json_encode(array_values($newContent));

        $this->data = $jsonData;

        return $this;
    }

    public function index($index)
    {
        $this->index = $index;

        return $this;
    }

    public function save()
    {
        file_put_contents($this->file, $this->data);

        return $this;
    }

    public function getBody()
    {
        $page = new HtmlPage(file_get_contents($this->url));
        $this->body = $page->filter('body');

        return $this;
    }

    public function getHTMLPage()
    {
        $curl = curl_init($this->url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HEADER => 0,
            ]);
        $result = curl_exec($curl);

        if (!$result) {
            print_r("ERROR: ${curl_error($curl)}"); exit;
        }

        $this->response = $result;

        curl_close($curl);

        return $this;
    }
}