<?php

namespace Policylead\Scraper\Parser\ArticleAuthor;

use Policylead\Scraper\Parser\ArticleAuthor as Base;
use Policylead\Scraper\Parser\Regexp\Pattern\Html;

class FromLinkTag extends Base
{
    private $parser;
    
    public function __construct()
    {
        $this->parser = new Html();
        
        $this->parser->addDefinitions(<<<DEF
        (?<link_rel_attribute>                rel="author")
DEF
);
        $this->parser->setPattern(array(
            'tag_begin',
            'attributes',
            'link_rel_attribute',
            'tag_end',
            'articleAuthor' => ['raw' => '[^<]*'],
        ));
    }

    /**
     * 
     * @param string $content html
     * @param int $slice to trim results
     * 
     * @return string[]
     */
    public function getarticleAuthor($content, $slice = null)
    {
        #echo $this->parser->buildRegexp();

        $author = $this->parser->match_all_get('articleAuthor', 
            $content, $matches);

        if($author) {
            return $author[0];
        }
    }

}

