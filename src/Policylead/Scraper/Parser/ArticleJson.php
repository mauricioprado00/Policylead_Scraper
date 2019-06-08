<?php

namespace Policylead\Scraper\Parser;
use Policylead\Scraper\Parser\Regexp\Pattern\Html;

class ArticleJson
{    
    public static function getParser()
    {
        $parser = new Html();
        
        $parser->addDefinitions(<<<DEF
        (?<scrypt_type_json>                type="(?&attribute_content)*   application\/ld\+json  (?&attribute_content)*")
DEF
);
        $parser->setPattern(array(
            'tag_begin',
            'scrypt_type_json',
            'tag_end',
            'json' => ['raw' => '.*?'],
            'close_tag',
        ));

        return $parser;
    }

}

