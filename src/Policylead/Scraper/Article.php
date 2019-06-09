<?php

namespace Policylead\Scraper;

class Article
{
    /**
     * @var string $url;
     */
    public $url;

    /**
     * @var string $title;
     */
    public $title;

    /**
     * @var string $author;
     */
    public $author;

    /**
     * @var string $date;
     */
    public $date;

    /**
     * @var string $excerpt;
     */
    public $excerpt;

    /**
     * @var string $text;
     */
    public $text;

    /**
     * @var string $storeLocation
     */
    private static $storeLocation;

    /**
     * @param mixed[]
     */
    public function __construct($data = null)
    {
        if (isset($data)) {
            foreach ($this as $key => $null) {
                if (isset($data[$key])) {
                    $this->$key = $data[$key];
                }
            }
        }
    }

    /**
     * @param string $location
     */
    public static function setStoreLocation($location)
    {
        self::$storeLocation = $location;
    }

    /**
     * generates unike key to use as storage name
     * @return string
     */
    private function storeKey()
    {
        return md5($this->url);
    }

    /**
     * @return string
     */
    public function jsonEncode()
    {
        return json_encode([
            'url' => $this->url,
            'title' => $this->title,
            'author' => $this->author,
            'date' => $this->date,
            'excerpt' => $this->excerpt,
            'text' => $this->text,
        ]);
    }

    /**
     * Stores the article as as json
     * in the configured store location
     * @return string | boolean
     */
    public function store()
    {
        $json = $this->jsonEncode();
        $file = $this->getStoreLocation();
        $result = file_put_contents($file, $json);
        return $result  ? $file : false;
    }

    /**
     * check if article is already stored
     * @return boolean
     */
    public function isStored()
    {
        $file = $this->getStoreLocation();
        return file_exists($file);
    }

    /**
     * @return string
     */
    public function getStoreLocation()
    {
        $file = realpath(self::$storeLocation) . '/' . $this->storeKey() . '.json';
        return $file;
    }


    /**
     * @param string $url
     * @return boolean
     */
    public static function isArticleStored($url)
    {
        $instance = new self();
        $instance->url = $url;
        return $instance->isStored();
    }
}