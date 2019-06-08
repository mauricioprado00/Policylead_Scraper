<?php

namespace Policylead\Scraper\Parser\ArticleLink;

class V1Test extends \Policylead\Scraper\TestCase 
{
    public function getTestCases()
    {
        return array(
            array(
                'politik.html',
                array (
                )
            ),
        );
    }

    /**
     * @test
     * @dataProvider getTestCases
     */
    public function articleLinksWillBeParsed($file, $expected)
    {
        $content = $this->readHtml($file);
        $parser = new V1();
        $actual = $parser->getArticleLinks($content);
        $this->assertEquals($expected, $actual);
    }
}