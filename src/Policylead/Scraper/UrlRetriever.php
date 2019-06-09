<?php

namespace Policylead\Scraper;

class UrlRetriever
{

    private $content;
    private $httpCode;
    private $errorMessage;
    private static $enableLogging;

    /**
     * Enables and disable logging of url and content to file
     * 
     * @param bool $enableLogging
     */
    public static function enableLogging($enableLogging)
    {
        self::$enableLogging = $enableLogging;
    }

    /**
     * Will log url and content in case logging is enabled
     * 
     * @param string $url
     * @param string $content
     */
    
    private static function logContent($url, $content)
    {
        if (self::$enableLogging) {
            $file = dirname(__FILE__) . '/' . md5($url);
            file_put_contents($file, $content);

            echo "Url {$url} retrieved to {$file}\n";
        }
    }

    /**
     * resets object status
     */
    private function reset()
    {
        $this->content = null;
        $this->httpCode = null;
        $this->errorMessage = null;
    }

    public function fetch($url)
    {
        $this->reset();
        // First, crawl the start site at Idealo (combination of baselink + EAN)
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);       // stop when it encounters an error
        if (preg_match('(^https?:\/\/(?P<username_and_password>[^@]+)@)', $url, $match)) {
            curl_setopt($ch, CURLOPT_USERPWD, $match['username_and_password']);
        }
        //saves the first extraction in firstrun for further analysis
        $this->content = curl_exec($ch);
        // Check if errors occured
        $this->errorMessage = curl_error($ch);

        // Show HTTP Code of URL
        $this->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        self::logContent($url, $this->content);
    }

    /**
     * returns the content fetched by the http request
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * returns the http code returned by the http request
     *
     * @return string
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * Will analize response code and content 
     * to determine if the result is correct
     * 
     * A string will be return in case of errors founds, null otherwise.
     * 
     * @return string | null
     */
    public function getErrorMessage()
    {
        if ($this->errorMessage) {
            return $this->errorMessage;
        }
        
        $check = $this->getHttpCode();

        switch ($check) {
            case 200:
                if ($this->content === false) {
                    return "No CURL-Result! (HTTP code: {$check}, url: {$this->idealolink})\n";
                }

                if (strlen($this->content) < 250) {
                    return "Response is too short!, site contains less than 250 chars. " .
                        "(HTTP code: {$check}, url: {$this->idealolink})\n";
                }
                return null;
            case 301:
            case 302:
                return "Redirection. (HTTP code: {$check}, url: {$this->idealolink})\n";
        }
        
        return "Unknown response code. (HTTP code: {$check}, url: {$this->idealolink})\n";
    }

    
}
