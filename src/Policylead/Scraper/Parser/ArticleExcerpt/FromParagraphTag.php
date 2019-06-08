<?php

namespace Policylead\Scraper\Parser\ArticleExcerpt;

use Policylead\Scraper\Parser\ArticleExcerpt as Base;
use Policylead\Scraper\Parser\Regexp\Pattern\Html;

class FromParagraphTag extends Base
{
    private $parser;
    
    public function __construct()
    {
        $this->parser = new Html();
        
        $this->parser->addDefinitions(<<<DEF
        (?<paragraph_class_attribute>                class="article-intro")
DEF
);
        $this->parser->setPattern(array(
            'tag_begin',
            'paragraph_class_attribute',
            'tag_end',
            'start_tag',
            'articleExcerpt' => ['raw' => '[^<]*'],
            'close_tag',
        ));
    }

    /**
     * 
     * @param string $content html
     * @param int $slice to trim results
     * 
     * @return string[]
     */
    public function getarticleExcerpt($content, $slice = null)
    {
        #echo $this->parser->buildRegexp();

        $excerpt = $this->parser->match_all_get('articleExcerpt', 
            $content, $matches);

        if($excerpt) {
            return $excerpt[0];
        }
    }

}

