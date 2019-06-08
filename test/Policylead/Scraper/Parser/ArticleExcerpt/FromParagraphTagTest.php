<?php

namespace Policylead\Scraper\Parser\ArticleExcerpt;

use Policylead\Scraper\Parser\ArticleExcerpt\FromParagraphTag as Model;

class FromParagraphTagTest extends TestCase
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