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

    /**
     * @var Parser\ArticleLink $articleLinkParser
     */
    private $articleLinkParser;

    /**
     * @param UrlRetriever $urlRetriever
     * @param Parser\ArticleLink $articleLinkParser
     */
    public function __construct($urlRetriever = null, 
        $articleLinkParser = null)
    {
        $this->setUrlRetriever($urlRetriever ? 
            $urlRetriever : new UrlRetriever());

        $this->setArticleLinkParser($articleLinkParser ? 
            $articleLinkParser : new Parser\ArticleLink\Def());
    }

    /**
     * @param Parser\ArticleLink $articleLinkParser
     * @return Crawler
     */
    public function setArticleLinkParser($articleLinkParser)
    {
        $this->articleLinkParser = $articleLinkParser;
        return $this;
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

            if (!$articleUrlList) {
                $articleUrlList = [$this->url];
            }

            foreach ($articleUrlList as $articleUrl) {
                $article = $this->crawlArticle($articleUrl);
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

        $this->urlRetriever->fetch($url);

        $content = $this->urlRetriever->getContent();
        if ($content) {
            $result = $this->articleLinkParser
                ->getArticleLinks($content);
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

        $articleUrl = $this->getArticleUrl($url);
        $this->urlRetriever->fetch($articleUrl);

        $content = $this->urlRetriever->getContent();
        if ($content) {
            $result = $this->parseArticle($content);
        } else {
            $this->lastErrorMessage = 'Could not retrieve article.';
            $this->lastErrorCode = 2;
            $errorMessage = $this->urlRetriever->getErrorMessage();
            if ($errorMessage) {
                $this->lastErrorMessage .= PHP_EOL . $errorMessage;
            }
        }
        
        return $result;
    }

    /**
     * @return string[]
     */
    private function parseArticle($content)
    {
        $article = [];

        return $article;
    }

    /**
     * @return string
     */
    public function getArticleUrl($url)
    {
        $host = parse_url($url, PHP_URL_HOST);
        if (isset($host)) {
            return $url;
        }


        $host = parse_url($this->url, PHP_URL_HOST);
        $scheme = parse_url($this->url, PHP_URL_SCHEME);
        $user = parse_url($this->url, PHP_URL_USER);
        $pass = parse_url($this->url, PHP_URL_PASS);
        $port = parse_url($this->url, PHP_URL_PORT);

        $url = ltrim($url, '/');
        $userpass = $user ? $user . ':' . $pass . '@' : '';
        $port = $port ? ':' . $port : '';
        $url = $scheme . ':' . '//' . $userpass . $host . $port . '/' . $url;
        return $url;
    }
}
