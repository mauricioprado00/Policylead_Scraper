<?php

namespace Policylead\Scraper\Parser\ArticleText;

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
                'expected-a-1271217.html',
            ),
        );
    }

    /**
     * @test
     * @dataProvider getTestCases
     */
    public function articleTextWillBeParsed($file, $expected_file)
    {
        $content = $this->readHtml($file);
        $parser = $this->getInstance();
        $expected = file_get_contents(dirname(__FILE__) . '/' . $expected_file);
        $actual = $parser->getArticleText($content, 2);
        $this->assertEquals($expected, $actual);
    }
}