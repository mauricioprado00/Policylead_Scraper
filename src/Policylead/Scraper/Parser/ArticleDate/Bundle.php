<?php

namespace Policylead\Scraper\Parser\ArticleDate;

use Policylead\Scraper\Parser\ArticleDate as Base;

class Bundle extends Base
{
    /**
     * @var Base[] $parsers
     */
    private $parsers = [];

    /**
     * @param Base $parser
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
    public function getArticleDate($content, $slice = null)
    {
        foreach ($this->parsers as $parser) {
            $result = $parser->getArticleDate($content, $slice);
            if ($result) {
                return $result;
            }
        }
    }
}

