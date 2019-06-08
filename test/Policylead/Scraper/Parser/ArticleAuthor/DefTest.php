<?php

namespace Policylead\Scraper\Parser\ArticleAuthor;

use Policylead\Scraper\Parser\ArticleAuthor\Def as Model;

class DefTest extends TestCase
{
    /**
     * @return \Policylead\Scraper\Parser\ArticleTitle
     */
    public function getInstance()
    {
        $parser = new Model();
        return $parser;
    }
}