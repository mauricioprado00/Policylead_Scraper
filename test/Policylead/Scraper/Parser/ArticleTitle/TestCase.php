<?php

namespace Policylead\Scraper\Parser\ArticleTitle;

abstract class TestCase extends \Policylead\Scraper\TestCase 
{
    /**
     * @return \Policylead\Scraper\Parser\ArticleTitle
     */
    abstract public function getInstance();

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
        $parser = $this->getInstance();
        $actual = $parser->getArticleTitle($content, 2);
        $this->assertEquals($expected, $actual);
    }
}