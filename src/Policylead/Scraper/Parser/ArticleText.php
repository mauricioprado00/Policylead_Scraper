<?php

namespace Policylead\Scraper\Parser;

/**
 * This class takes an html content of the `article` 
 * and extracts the article author
 * 
 * Class ArticleText
 * @package Policylead\Scraper\Parser
 */
abstract class ArticleText
{
    /**
     * 
     * @param string $content html
     * @param int $slice to trim results
     * 
     * @return string
     */
    abstract public function getArticleText($content, $slice = null);
}

