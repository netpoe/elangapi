<?php 

namespace Elang\Library\Scraper\es_MX;

use Elang\Library\Scraper\AbstractBaseScraper;
use Wa72\HtmlPageDom\HtmlPageCrawler;
use Wa72\HtmlPageDom\HtmlPage;

class VerbsScraper extends AbstractBaseScraper
{
    public $hostname = 'https://www.vocabulix.com';

    public $path = 'conjugacion2';

    /* 
     * This is how the URI paths are defined in the website we are scraping
     * 
     * */
    public $lettersPathString = 'a_a1_a2_b_c_c1_d_d1_e_e1_f_g_h_i_j_k_l_m_n_o_p_p1_q_r_r1_s_t_u_v_w_x_y_z';

    public $letters = [];

    const DELAY_CURL_TIME = 2000000;

    public function __construct(String $langCode)
    {
        $this->lang = $langCode;
        $this->letters = explode('_', $this->lettersPathString);
        $this->directory = dirname(__DIR__, 3) . "/lib/lang/{$this->lang}/verbs";
    }

    public function removeDuplicates()
    {
        foreach ($this->letters as $index) {
            $this->index($index)
                ->normalize()
                ->onFile()
                ->clean()
                ->save();
        }

        return $this;
    }

    public function scrape()
    {
        foreach ($this->letters as $index) {
            $this->index($index)
                ->makeURL()
                ->getBody()
                ->getVerbs()
                ->normalize()
                ->onFile()
                ->combineJson()
                ->save()
                ->reset();
        }

        return $this;
    }

    public function reset()
    {
        $this->data = [];

        return $this;
    }

    public function makeURL()
    {
        $this->url = "{$this->hostname}/{$this->path}/{$this->index}_spanish.html";

        return $this;
    }

    public function getVerbs()
    {
        $verbs = $this->body->filter('.indexWrapper .indexColumn a');
        $verbs->each(function($verb){
            array_push($this->data, $verb->text());
        });

        return $this;
    }

    public function normalize()
    {
        if (strlen($this->index) > 1) {
            $extraString = substr($this->index, 1);
            $this->index = str_replace($extraString, '', $this->index);
        }

        return $this;
    }
}





