<?php 

namespace Elang\Library\Scraper\es_MX;

use Wa72\HtmlPageDom\HtmlPageCrawler;

class VerbsScraper
{
    public $hostname = 'www.vocabulix.com';

    public $path = 'conjuacion2';

    /* 
     * This is how the URI paths are defined in the website we are scraping
     * 
     * */
    public $lettersPathString = 'a_a1_a2_b_c_c1_d_d1_e_e1_f_g_h_i_j_k_l_m_n_o_p1_q_r1_s_t_u_v_w_x_y_z';

    public $letters = explode('_', $lettersPathString);

    public $lang = 'es_MX';

    public function saveVerbsToLib()
    {
        return $this
                ->scrapeVerbs()
                ->getVerbs()
                ->save();
    }

    public function getVerbs()
    {

    }

    public function scrapeVerbs()
    {
        foreach ($letters as $letter) {
            $this->getHTML()
        }
        return array_map(function($verb){

        }, $letters);
    }

    public function makeRequest()
    {

    }

    public function getHTML()
    {

    }

    public function save()
    {
        
    }
}