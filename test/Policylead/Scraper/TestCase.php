<?php

namespace Policylead\Scraper;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Reads an html file from the test repository
     * 
     * @param $name
     * @return string
     */
    protected function readHtml($name)
    {
        return file_get_contents(dirname(__FILE__) . '/html_fetches/' . $name);
    }
}
