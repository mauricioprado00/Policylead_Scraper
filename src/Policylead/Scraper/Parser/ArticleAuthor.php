<?php

namespace Policylead\Scraper\Parser;

/**
 * This class takes an html content of the `article` 
 * and extracts the article author
 * 
 * Class ArticleAuthor
 * @package Policylead\Scraper\Parser
 */
abstract class ArticleAuthor
{
	/**
     * 
     * @param string $content html
     * @param int $slice to trim results
     * 
	 * @return string
	 */
	abstract public function getArticleAuthor($content, $slice = null);
}

