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
     * @var Parser\ArticleTitle $articleTitleParser
     */
    private $articleTitleParser;

    /**
     * @var Parser\ArticleAuthor $articleAuthorParser
     */
    private $articleAuthorParser;

    /**
     * @var Parser\ArticleDate $articleDateParser
     */
    private $articleDateParser;

    /**
     * @var Parser\ArticleExcerpt $articleExcerptParser
     */
    private $articleExcerptParser;

    /**
     * @var Parser\ArticleText $articleTextParser
     */
    private $articleTextParser;

    /**
     * @param UrlRetriever $urlRetriever
     * @param Parser\ArticleLink $articleLinkParser
     * @param Parser\ArticleTitle $articleTitleParser
     * @param Parser\ArticleAuthor $articleAuthorParser
     * @param Parser\ArticleDate $articleDateParser
     * @param Parser\ArticleExcerpt $articleExcerptParser
     * @param Parser\ArticleText $articleTextParser
     */
    public function __construct($urlRetriever = null, 
        $articleLinkParser = null, 
        $articleTitleParser = null, 
        $articleAuthorParser = null,
        $articleDateParser = null,
        $articleExcerptParser = null,
        $articleTextParser = null)
    {
        $this->setUrlRetriever($urlRetriever ? 
            $urlRetriever : new UrlRetriever());

        $this->setArticleLinkParser($articleLinkParser ? 
            $articleLinkParser : new Parser\ArticleLink\Def());

        $this->setArticleTitleParser($articleTitleParser ? 
            $articleTitleParser : new Parser\ArticleTitle\Def());

        $this->setArticleAuthorParser($articleAuthorParser ? 
            $articleAuthorParser : new Parser\ArticleAuthor\Def());

        $this->setArticleDateParser($articleDateParser ? 
            $articleDateParser : new Parser\ArticleDate\Def());

        $this->setArticleExcerptParser($articleExcerptParser ? 
            $articleExcerptParser : new Parser\ArticleExcerpt\Def());

        $this->setArticleTextParser($articleTextParser ? 
            $articleTextParser : new Parser\ArticleText\Def());
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
     * @param Parser\ArticleTitle $articleTitleParser
     * @return Crawler
     */
    public function setArticleTitleParser($articleTitleParser)
    {
        $this->articleTitleParser = $articleTitleParser;
        return $this;
    }

    /**
     * @param Parser\ArticleAuthor $articleAuthorParser
     * @return Crawler
     */
    public function setArticleAuthorParser($articleAuthorParser)
    {
        $this->articleAuthorParser = $articleAuthorParser;
        return $this;
    }

    /**
     * @param Parser\ArticleDate $articleDateParser
     * @return Crawler
     */
    public function setArticleDateParser($articleDateParser)
    {
        $this->articleDateParser = $articleDateParser;
        return $this;
    }

    /**
     * @param Parser\ArticleExcerpt $articleExcerptParser
     * @return Crawler
     */
    public function setArticleExcerptParser($articleExcerptParser)
    {
        $this->articleExcerptParser = $articleExcerptParser;
        return $this;
    }

    /**
     * @param Parser\ArticleText $articleTextParser
     * @return Crawler
     */
    public function setArticleTextParser($articleTextParser)
    {
        $this->articleTextParser = $articleTextParser;
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
                ->getArticleLinks($content, 2);
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
            $result = $this->parseArticle($content, $articleUrl);
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
     * @param string $content
     * @param string $url
     * @return string[]
     */
    private function parseArticle($content, $url)
    {
        $article = [];

        $article['url'] = $url;

        $article['title'] = $this->articleTitleParser
            ->getArticleTitle($content, 2);

        $article['author'] = $this->articleAuthorParser
            ->getArticleAuthor($content, 2);

        $article['date'] = $this->articleDateParser
            ->getArticleDate($content, 2);

        $article['excerpt'] = $this->articleExcerptParser
            ->getArticleExcerpt($content, 2);

        $article['text'] = $this->articleTextParser
            ->getArticleText($content, 2);

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
