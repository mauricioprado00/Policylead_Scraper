<?php

namespace Policylead\Scraper\Parser\Regexp\Pattern;

use Policylead\Scraper\Parser\Regexp\Pattern;

class Html extends Pattern
{
    public function __construct()
    {
        $this->addDefinitions(<<<DEF
        
        (?<any_space>              \s*)
        (?<close_tag>              <\/[a-zA-Z_0-9]+)
        (?<tag_begin>              <[a-zA-Z_0-9]+\s)
        (?<tag_end>                .*?>)
        (?<start_tag>              <[a-zA-Z_0-9]+>)
        (?<span>                   <span>)  
        (?<attribute_content>      [^"])
        (?<attribute_contents>     (?&attribute_content)+)
        (?<href_start_double>      href=")
        (?<href_start_single>      href=")
        (?<href_start>             (?&href_start_double) | (?&href_start_single))
        (?<attribute_start>        [a-z-]+=")
        (?<attribute_end_single>   ')
        (?<attribute_end_double>   ")
        (?<attribute_end>          (?&attribute_end_double) | (?&attribute_end_single))
        (?<attribute>              (?&attribute_start)  (?&attribute_contents)  (?&attribute_end))
        (?<attributes>             (?&attribute) ((?&any_space) (?&attribute))*) 
        (?<target_blank_double>    target="_blank")
        (?<target_blank_single>    target='_blank')
        (?<target_blank>           (?&target_blank_double) | (?&target_blank_single))
        (?<tag_end_attributes>     (?&attributes)* (?&tag_end))
        (?<text>                   [^<]*)

DEF
);
    }
}
