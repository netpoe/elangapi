<?php 

namespace Elang\Library\Scraper\es_MX;

use Wa72\HtmlPageDom\HtmlPageCrawler;

class VerbsScraper
{
    public $hostname = 'https://www.vocabulix.com';

    public $path = 'conjugacion2';

    /* 
     * This is how the URI paths are defined in the website we are scraping
     * 
     * */
    public $lettersPathString = 'a_a1_a2_b_c_c1_d_d1_e_e1_f_g_h_i_j_k_l_m_n_o_p1_q_r1_s_t_u_v_w_x_y_z';

    public $letters = [];

    public $lang = 'es_MX';

    public $response = '';

    public $verbs = [];

    const DELAY_CURL_TIME = 2000000;

    public function __construct()
    {
        $this->letters = explode('_', $this->lettersPathString);
    }

    public function saveVerbsToLib()
    {
        return $this
                ->scrape()
                ->get()
                ->save();
    }

    public function get()
    {

    }

    public function scrape()
    {
        $this->verbs = array_map(function($letter){
            usleep(self::DELAY_CURL_TIME);
            $this->makeURL($letter)
                ->enter()
                ->getBody();
        }, $this->letters);

        return $this;
    }

    public function makeURL(String $letter)
    {
        $this->url = "{$this->hostname}/{$this->path}/{$letter}_spanish.html";

        return $this;
    }

    public function enter()
    {
        $curl = curl_init($this->url);
        $result = curl_exec($curl);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            ]);

        if (!$result) {
            print_r("ERROR: ${curl_error($curl)}"); exit;
        }

        curl_close($curl);

        $this->response = $result;

        return $this;
    }

    public function getBody()
    {
        $this->response = str_replace('/<!DOCTYPE[\s\S]*?<\/head>/g', $this->response, '');
        $this->response = str_replace('/<\/body>[\s\S]*?<\/html>/g', $this->response, '</body>');
        print_r($this->response); exit;
    }

    public function save()
    {

    }
}