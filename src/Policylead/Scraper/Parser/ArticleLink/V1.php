<?php

namespace Policylead\Scraper\Parser\ArticleLink;

use Policylead\Scraper\Parser\ArticleLink as Base;

class V1 extends Base
{
    /**
     * 
     * @param string $content html
     * @param int $slice to trim results
     * 
     * @return string[]
     */
    public function getArticleLinks($content, $slice = null)
    {
        $links = [];
        return $links;
    }

}

