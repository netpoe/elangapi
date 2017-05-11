<?php 

namespace Elang\Library\Scraper\es_MX;

use Wa72\HtmlPageDom\HtmlPageCrawler;
use Wa72\HtmlPageDom\HtmlPage;

class VerbsScraper
{
    public $hostname = 'https://www.vocabulix.com';

    public $path = 'conjugacion2';

    public $directory = '';

    /* 
     * This is how the URI paths are defined in the website we are scraping
     * 
     * */
    public $lettersPathString = 'a_a1_a2_b_c_c1_d_d1_e_e1_f_g_h_i_j_k_l_m_n_o_p_p1_q_r_r1_s_t_u_v_w_x_y_z';

    public $letters = [];

    public $currentLetter = '';

    public $lang = 'es_MX';

    public $response = '';

    public $body = '';

    public $verbs = [];

    const DELAY_CURL_TIME = 2000000;

    public function __construct()
    {
        $this->letters = explode('_', $this->lettersPathString);
        $this->directory = dirname(__DIR__, 3) . "/lib/lang/{$this->lang}/verbs";
    }

    public function saveVerbsToLib()
    {
        return $this->scrape();
    }

    public function removeDuplicates()
    {
        foreach ($this->letters as $letter) {
            $this->setCurrentLetter($letter)
                ->normalizeCurrentLetter()
                ->getFile();
        }

        return $this;
    }

    public function getFile()
    {
        $this->file = "{$this->directory}/{$this->currentLetter}.json";
    }

    public function scrape()
    {
        foreach ($this->letters as $letter) {
            // usleep(self::DELAY_CURL_TIME);
            $this->setCurrentLetter($letter)
                ->makeURL()
                ->getBody()
                ->getVerbs()
                ->normalizeCurrentLetter()
                ->save()
                ->reset();
        }

        return $this;
    }

    public function reset()
    {
        $this->verbs = [];

        return $this;
    }

    public function setCurrentLetter(String $letter)
    {
        $this->currentLetter = $letter;

        return $this;
    }

    public function makeURL()
    {
        $this->url = "{$this->hostname}/{$this->path}/{$this->currentLetter}_spanish.html";

        return $this;
    }

    public function enter()
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

    public function getBody()
    {
        $page = new HtmlPage(file_get_contents($this->url));
        $this->body = $page->filter('body');

        return $this;
    }

    public function getVerbs()
    {
        $verbs = $this->body->filter('.indexWrapper .indexColumn a');
        $verbs->each(function($verb){
            array_push($this->verbs, $verb->text());
        });

        return $this;
    }

    public function normalizeCurrentLetter()
    {
        if (strlen($this->currentLetter) > 1) {
            $extraString = substr($this->currentLetter, 1);
            $this->currentLetter = str_replace($extraString, '', $this->currentLetter);
        }

        return $this;
    }

    public function save()
    {
        $fileLocation = "{$this->directory}/{$this->currentLetter}.json";
        
        if (!file_exists($fileLocation)) {
            $file = fopen($fileLocation, 'w');
            $content = '[]';
            fwrite($file, $content);
            fclose($file);
        }

        $data = file_get_contents($fileLocation);
        $tempArray = json_decode($data, true);
        $content = array_merge($tempArray, $this->verbs);
        $jsonData = json_encode($content);
        file_put_contents($fileLocation, $jsonData);
        
        return $this;
    }
}





