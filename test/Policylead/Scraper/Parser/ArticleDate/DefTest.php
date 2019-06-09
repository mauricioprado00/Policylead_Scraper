<?php

namespace Policylead\Scraper\Parser\ArticleDate;

use Policylead\Scraper\Parser\ArticleDate\Def as Model;

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