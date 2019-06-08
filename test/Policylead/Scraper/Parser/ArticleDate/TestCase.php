<?php

namespace Policylead\Scraper\Parser\ArticleDate;

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
                '2019-06-07T17:58:00+0200',
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
        $actual = $parser->getArticleDate($content, 2);
        $this->assertEquals($expected, $actual);
    }
}