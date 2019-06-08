<?php

namespace Policylead\Scraper\Parser\ArticleAuthor;

use Policylead\Scraper\Parser\ArticleAuthor as Base;

class Bundle extends Base
{
    /**
     * @var \Policylead\Scraper\Parser\ArticleAuthor[] $parsers
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
    public function getArticleAuthor($content, $slice = null)
    {
        foreach ($this->parsers as $parser) {
            $result = $parser->getArticleAuthor($content, $slice);
            if ($result) {
                return $result;
            }
        }
    }
}

