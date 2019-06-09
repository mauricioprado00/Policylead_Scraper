<?php

namespace Policylead\Scraper;

class CrawlerTest extends \PHPUnit_Framework_TestCase
{
    public function getInstance()
    {
        return new Crawler();
    }

    public function articleUrls()
    {
        return [
            'will-use-domain-of-base-url' => [
                'http://example.com/',
                '/the/article',
                'http://example.com/the/article',
            ],
            'will-ignore-domain-of-base-url' => [
                'http://example.com/',
                'http://somehwere-else.com/the/article',
                'http://somehwere-else.com/the/article',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider articleUrls
     */
    public function getArticleUrlWillResolveUrls($url, $articleUrl, $expected)
    {
        $instance = $this->getInstance();
        $instance->setUrl($url);
        $actual = $instance->getArticleUrl($articleUrl);
        $this->assertEquals($expected, $actual, 'should be same urls');
    }
}
