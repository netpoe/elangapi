<?php 

namespace Elang\Scraper\es_MX;

use Elang\Scraper\AbstractBaseScraper;
use Elang\Model\Word;

class WordsScraper extends AbstractBaseScraper
{
    public $hostname = 'https://www.vocabulix.com';

    public $path = 'conjugacion2';

    public $namespace = 'words';

    /* 
     * This is how the URI paths are defined in the website we are scraping
     * 
     * */
    public $lettersPathString = 'a_a1_a2_b_c_c1_d_d1_e_e1_f_g_h_i_j_k_l_m_n_o_p_p1_q_r_r1_s_t_u_v_w_x_y_z';

    public $letters = [];

    const DELAY_CURL_TIME = 2000000;

    public function createWord(String $word)
    {
        $word = Word::create(['word' => $word]);

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
}





