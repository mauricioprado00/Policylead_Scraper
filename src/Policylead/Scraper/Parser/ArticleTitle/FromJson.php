<?php

namespace Policylead\Scraper\Parser\ArticleTitle;

use Policylead\Scraper\Parser\ArticleTitle as Base;
use Policylead\Scraper\Parser\ArticleJson;

class FromJson extends Base
{
    private $parser;
    
    public function __construct()
    {
        $this->parser = ArticleJson::getParser();
    }

    /**
     * 
     * @param string $content html
     * @param int $slice to trim results
     * 
     * @return string[]
     */
    public function getArticleTitle($content, $slice = null)
    {
        #echo $this->parser->buildRegexp();

        $json = $this->parser->match_all_get('json', 
            $content, $matches);

        if($json) {
            $obj = json_decode($json[0]);
            if ($obj) {
                if (isset($obj->headline)) {
                    $headlines = explode(': ', $obj->headline);
                    return $headlines;
                }
            }
        }
    }

}

