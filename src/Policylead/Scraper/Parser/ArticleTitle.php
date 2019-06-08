<?php

namespace Policylead\Scraper\Parser;

/**
 * This class takes an html content of the `article` 
 * and extracts the article title
 * 
 * Class ArticleTitle
 * @package Policylead\Scraper\Parser
 */
abstract class ArticleTitle
{
	/**
     * 
     * @param string $content html
     * @param int $slice to trim results
     * 
	 * @return string
	 */
	abstract public function getArticleTitle($content, $slice = null);
}

