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
}