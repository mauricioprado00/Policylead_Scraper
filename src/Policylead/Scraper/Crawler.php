<?php

namespace Policylead\Scraper;

class Crawler
{
    /**
     * @var string $url
     */
    private $url;

    /**
     * @var array[]
     */
    private $articles;

    /**
     * @var UrlRetriever $urlRetriever
     */
    private $urlRetriever;

    /**
     * @var string $lastErrorMessage
     */
    private $lastErrorMessage;

    /**
     * @var string $lastErrorCode
     */
    private $lastErrorCode;

    public function __construct($urlRetriever = null)
    {
        $this->setUrlRetriever($urlRetriever ? 
            $urlRetriever : new UrlRetriever());
    }

    /**
     * @return string
     */
    public function getLastErrorMessage()
    {
        return $this->lastErrorMessage;
    }

    /**
     * @return string
     */
    public function getLastErrorCode()
    {
        return $this->lastErrorCode;
    }

    /**
     * Sets the url retriever
     *
     * @param UrlRetriever $urlRetriever
     * @return $this
     */
    public function setUrlRetriever($urlRetriever)
    {
        $this->urlRetriever = $urlRetriever;

        return $this;
    }

    /**
     * @return Crawler
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return array[]
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @return boolean
     */
    public function crawl()
    {
        $result = false;

        if ($this->url) {
            $articleUrlList = $this->crawlArticleList($this->url);
            if (!$result) {
                $articleUrlList = [$this->url];
            }

            foreach ($articleUrlList as $articleUrl) {
                $article = $this->crawlArticle($this->url);
                if ($article) {
                    $this->articles[] = $article;
                }
            }
        }

        return $result;
    }

    /**
     * @param string $url
     * @return string[] | null
     */
    private function crawlArticleList($url)
    {
        $result = null;

        $this->urlRetriever->fetch($this->url);

        $content = $this->urlRetriever->getContent();
        if ($content) {
            $result = [];
        } else {
            $this->lastErrorMessage = 'Could not retrieve article list.';
            $this->lastErrorCode = 1;
            $errorMessage = $this->urlRetriever->getErrorMessage();
            if ($errorMessage) {
                $this->lastErrorMessage .= PHP_EOL . $errorMessage;
            }
        }
        
        return $result;
    }

    /**
     * @param string $url
     * @return string[]
     */
    private function crawlArticle($url)
    {
        $result = null;

        return $result;
    }
}
