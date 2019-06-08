<?php

namespace Policylead\Scraper\Parser\ArticleTitle;

use Policylead\Scraper\Parser\ArticleTitle as Base;
use Policylead\Scraper\Parser\ArticleJson;

class Bundle extends Base
{
    /**
     * @var \Policylead\Scraper\Parser\ArticleTitle[] $parsers
     */
    private $parsers = [];

    /**
     * @param $parser
     * @return $this
     */
    public function addParser($parser)
    {
        $this->parsers[] = $parser;
        return $this;
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
        foreach ($this->parsers as $parser) {
            $result = $parser->getArticleTitle($content, $slice);
            if ($result) {
                return $result;
            }
        }
    }
}

