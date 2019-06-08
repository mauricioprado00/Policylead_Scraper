<?php

namespace Policylead\Scraper\Parser\ArticleDate;

use Policylead\Scraper\Parser\ArticleDate\FromJson as Model;

class FromJsonTest extends TestCase
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