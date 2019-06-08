<?php

namespace Policylead\Scraper\Parser\ArticleTitle;

use Policylead\Scraper\Parser\ArticleTitle\FromHeadline as Model;

class FromHeadlineTest extends TestCase
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