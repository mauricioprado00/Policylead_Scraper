<?php

namespace Policylead\Scraper\Parser\ArticleDate;

use Policylead\Scraper\Parser\ArticleDate as Base;
use Policylead\Scraper\Parser\Regexp\Pattern\Html;

class FromMeta extends Base
{
    private $parser;
    
    public function __construct()
    {
        $this->parser = new Html();
        
        $this->parser->addDefinitions(<<<DEF
        (?<meta_name_attribute>                name="date")
        (?<meta_content_attribute>             content=")
DEF
);
        $this->parser->setPattern(array(
            'tag_begin',
            'meta_name_attribute',
            'meta_content_attribute',
            'articleDate' => 'attribute_contents',
        ));
    }

    /**
     * 
     * @param string $content html
     * @param int $slice to trim results
     * 
     * @return string[]
     */
    public function getArticleDate($content, $slice = null)
    {
        #echo $this->parser->buildRegexp();

        $author = $this->parser->match_all_get('articleDate', 
            $content, $matches);

        if($author) {
            return $author[0];
        }
    }

}

