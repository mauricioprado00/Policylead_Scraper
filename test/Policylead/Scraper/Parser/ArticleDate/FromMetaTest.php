<?php

namespace Policylead\Scraper\Parser\ArticleDate;

use Policylead\Scraper\Parser\ArticleDate\FromMeta as Model;

class FromMetaTest extends TestCase
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