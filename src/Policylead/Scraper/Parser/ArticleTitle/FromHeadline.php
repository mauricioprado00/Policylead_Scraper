<?php

namespace Policylead\Scraper\Parser\ArticleTitle;

use Policylead\Scraper\Parser\ArticleTitle as Base;
use Policylead\Scraper\Parser\Regexp\Pattern\Html;

class FromHeadline extends Base
{
    private $parser;
    
    public function __construct()
    {
        $this->parser = new Html();
        
        $this->parser->addDefinitions(<<<DEF
        (?<link_class_attribute>                class="(?&attribute_content)*   headline  (?&attribute_content)*")
DEF
);
        $this->parser->setPattern(array(
            'tag_begin',
            'link_class_attribute',
            'tag_end',
            'articleTitle' => ['raw' => '[^<]*'],
        ));
    }

    /**
     * 
     * @param string $content html
     * @param int $slice to trim results
     * 
     * @return string[]
     */
    public function getArticleTitle($content, $slice = null)
    {
        #echo $this->parser->buildRegexp();

        $title = $this->parser->match_all_get('articleTitle', 
            $content, $matches);


        if($title) {
            return array_slice($title, 0, $slice);
        }
    }

}

