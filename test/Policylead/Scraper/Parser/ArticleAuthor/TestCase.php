<?php

namespace Policylead\Scraper\Parser\ArticleAuthor;

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
                'a-1271217.html',
                'Christoph Titz',
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
        $actual = $parser->getArticleAuthor($content, 2);
        $this->assertEquals($expected, $actual);
    }
}