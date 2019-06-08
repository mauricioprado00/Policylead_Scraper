<?php

namespace Policylead\Scraper\Parser\ArticleTitle;

class DefTest extends \Policylead\Scraper\TestCase 
{
    public function getTestCases()
    {
        return array(
            array(
                'a-1271484.html',
                array(
                  'Leserkommentare zum Juso-Chef',
                  '"Kühnert muss endlich übernehmen" - "Bloß nicht"',
                ),
            ),
        );
    }

    /**
     * @test
     * @dataProvider getTestCases
     */
    public function articleTitlesWillBeParsed($file, $expected)
    {
        $content = $this->readHtml($file);
        $parser = new Def();
        $actual = $parser->getArticleTitle($content, 2);
        $this->assertEquals($expected, $actual);
    }
}