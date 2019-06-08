<?php

namespace Policylead\Scraper\Parser\ArticleText;

use Policylead\Scraper\Parser\ArticleText\FromSection as Model;

class FromSectionTest extends TestCase
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