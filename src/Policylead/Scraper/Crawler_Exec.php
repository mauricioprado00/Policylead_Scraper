<?php

namespace Policylead\Scraper;

class Crawler_Exec
{

    private $url;

    private function parseArguments()
    {
        $shortopts  = "";

        $longopts  = array(
            "help::",
            "url::",
        );

        $options = getopt($shortopts, $longopts);
        if (isset($options['help'])) {
            $this->help = true;
        }
        if (isset($options['url'])) {
            $this->url = $options['url'];
        }

    }

    private function _run()
    {
        $this->parseArguments();
        $this->process();
    }

    private function process()
    {
        try {
            #UrlRetriever::enableLogging(true);

            echo 'Crawling ' . $this->url . PHP_EOL;
            $crawler = new Crawler();
            $crawler->setUrl($this->url);
            $result = $crawler->crawl();
            $articles = $crawler->getArticles();
            foreach ($articles as $article) {
                $file = $article->store();
                echo 'Article stored in ' . $file . PHP_EOL;
            }
            var_dump([
                'result' => $result, 
                'lastError' => $crawler->getLastErrorMessage(),
            ]);

        } catch(\Exception $e) {
            $message = "There was an error while trying to process the request. \n" . $e->getMessage() . PHP_EOL;
            ob_start();
            debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            $message .= ob_get_clean() . PHP_EOL . PHP_EOL;
            echo  $message;
        }
    }

    public static function run()
    {
        (new self())->_run();
    }

}
