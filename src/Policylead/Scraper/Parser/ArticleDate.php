<?php

namespace Policylead\Scraper\Parser;

/**
 * This class takes an html content of the `article` 
 * and extracts the article author
 * 
 * Class ArticleDate
 * @package Policylead\Scraper\Parser
 */
abstract class ArticleDate
{
    /**
     * 
     * @param string $content html
     * @param int $slice to trim results
     * 
     * @return string
     */
    abstract public function getArticleDate($content, $slice = null);
}

