<?php

namespace Policylead\Scraper\Parser\ArticleDate;

class Def extends Bundle
{
    public function __construct()
    {
        $this
            ->addParser(new FromJson())
            ->addParser(new FromMeta())
        ;

    }
}

