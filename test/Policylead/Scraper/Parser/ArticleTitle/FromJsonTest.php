<?php

namespace Policylead\Scraper\Parser\ArticleTitle;

use Policylead\Scraper\Parser\ArticleTitle\FromJson as Model;

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