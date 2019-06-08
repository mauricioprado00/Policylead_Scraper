<?php

namespace Policylead\Scraper\Parser\ArticleAuthor;

use Policylead\Scraper\Parser\ArticleAuthor as Base;
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
    public function getArticleAuthor($content, $slice = null)
    {
        $json = $this->parser->match_all_get('json', 
            $content, $matches);

        if($json) {
            $obj = json_decode($json[0]);
            if ($obj) {
                if (isset($obj->author[0]->name)) {
                    $author = $obj->author[0]->name;
                    return $author;
                }
            }
        }
    }

}

