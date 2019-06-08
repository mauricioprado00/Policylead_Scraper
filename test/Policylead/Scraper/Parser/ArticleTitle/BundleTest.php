<?php

namespace Policylead\Scraper\Parser\ArticleTitle;

use Policylead\Scraper\Parser\ArticleTitle\Def as Model;

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