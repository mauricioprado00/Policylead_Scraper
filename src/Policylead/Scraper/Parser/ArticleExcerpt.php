<?php

namespace Policylead\Scraper\Parser;

/**
 * This class takes an html content of the `article` 
 * and extracts the article author
 * 
 * Class ArticleExcerpt
 * @package Policylead\Scraper\Parser
 */
abstract class ArticleExcerpt
{
    /**
     * 
     * @param string $content html
     * @param int $slice to trim results
     * 
     * @return string
     */
    abstract public function getArticleExcerpt($content, $slice = null);
}

