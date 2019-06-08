<?php

namespace Policylead\Scraper\Parser\ArticleText;

use Policylead\Scraper\Parser\ArticleText as Base;
use Policylead\Scraper\Parser\Regexp\Pattern\Html;

class FromSection extends Base
{
    private $parser;
    
    public function __construct()
    {
        $this->parser = new Html();
        
        $this->parser->addDefinitions(<<<DEF
        (?<div_class_attribute>                class="(?&attribute_content)*article-section)
        (?<start_paragraph>         <p>)
        (?<end_paragraph>           <\/p>)
DEF
);
        $this->parser->setPattern(array(
            'tag_begin',
            'optional_attributes',
            'div_class_attribute',
            ['raw' => '.+?'],
            'start_paragraph',
            'articleText' => ['raw' => '.+'],
            'end_paragraph',
        ));       
    }

    /**
     * 
     * @param string $content html
     * @param int $slice to trim results
     * 
     * @return string[]
     */
    public function getArticleText($content, $slice = null)
    {
        #echo $this->parser->buildRegexp();

        $contents = explode('column-both', $content);


        foreach ($contents as $content) {

            $text = $this->parser->match_all_get('articleText', 
                $content, $matches);

            if($text) {
                $article_begin = $text[0];
                return $article_begin;
            }
        }
    }

}

