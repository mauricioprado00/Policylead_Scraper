<?php

namespace Policylead\Scraper\Parser\ArticleLink;

use Policylead\Scraper\Parser\ArticleLink as Base;
use Policylead\Scraper\Parser\Regexp\Pattern\Html;

class V1 extends Base
{
    private $parser;
    
    public function __construct()
    {
        $this->parser = new Html();
        
        $this->parser->addDefinitions(<<<DEF
        (?<link_class_attribute>                class="(?&attribute_content)*   article-title  (?&attribute_content)*")
DEF
);
        $this->parser->setPattern(array(
            'tag_begin',
            'link_class_attribute',
            'tag_end',
            'tag_begin',
            'href_start',
            'articleLink' => 'attribute_contents',
            'attribute_end',
        ));
    }

    /**
     * 
     * @param string $content html
     * @param int $slice to trim results
     * 
     * @return string[]
     */
    public function getArticleLinks($content, $slice = null)
    {
        $links = $this->parser->match_all_get('articleLink', 
            $content, $matches);

        #echo $this->parser->buildRegexp();

        if($links) {
            return array_slice($links, 0, $slice);
        }
    }

}

