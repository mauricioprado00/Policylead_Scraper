<?php

namespace Policylead\Scraper\Parser\ArticleAuthor;

class Def extends Bundle
{
    public function __construct()
    {
        $this
            ->addParser(new FromJson())
            ->addParser(new FromLinkTag())
        ;

    }
}

