<?php

namespace Policylead\Scraper\Parser\ArticleTitle;

class Def extends Bundle
{
    public function __construct()
    {
        $this
            ->addParser(new FromJson())
            ->addParser(new FromHeadline())
        ;

    }
}

