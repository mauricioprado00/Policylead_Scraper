<?php

namespace Policylead\Scraper\Parser\ArticleExcerpt;

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
                'Senegals Präsident Macky Sall profiliert sich als Korruptionsbekämpfer. Nun wird seinem Bruder Beteiligung an einem zwielichtigen Gasgeschäft vorgeworfen. Wurde das Land um Milliarden Dollar geprellt?',
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
        $actual = $parser->getArticleExcerpt($content, 2);
        $this->assertEquals($expected, $actual);
    }
}