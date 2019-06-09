<?php

namespace Policylead\Scraper\Parser;

/**
 * This class takes an html content of the `main page of spiegel` 
 * and extracts the price of the article links
 * 
 * Class ArticleLink
 * @package Policylead\Scraper\Parser
 */
abstract class ArticleLink
{
    /**
     * 
     * @param string $content html
     * @param int $slice to trim results
     * 
     * @return string[]
     */
    abstract public function getArticleLinks($content, $slice = null);
}

