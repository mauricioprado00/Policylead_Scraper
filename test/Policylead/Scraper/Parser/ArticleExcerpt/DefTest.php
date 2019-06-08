<?php

namespace Policylead\Scraper\Parser\ArticleExcerpt;

use Policylead\Scraper\Parser\ArticleExcerpt\Def as Model;

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