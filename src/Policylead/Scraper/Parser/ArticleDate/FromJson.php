<?php

namespace Policylead\Scraper\Parser\ArticleDate;

use Policylead\Scraper\Parser\ArticleDate as Base;
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
    public function getArticleDate($content, $slice = null)
    {
        $json = $this->parser->match_all_get('json', 
            $content, $matches);

        if($json) {
            $obj = json_decode($json[0]);
            if ($obj) {
                if (isset($obj->datePublished)) {
                    $date = $obj->datePublished;
                    return $date;
                }
            }
        }
    }

}

