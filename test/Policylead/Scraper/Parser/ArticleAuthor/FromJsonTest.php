<?php

namespace Policylead\Scraper\Parser\ArticleAuthor;

use Policylead\Scraper\Parser\ArticleAuthor\FromJson as Model;

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