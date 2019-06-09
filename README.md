## Environment setup

### install docker
this step is only for dockerized environments. Follow instructions in here:

https://docs.docker.com/engine/installation/

### update composer dependencies

./bin/composer-update


# Run unit test

run all unit tests:

```
./bin/phpunit.sh test/Policylead/Scraper
```

run a specific unit test
```
./bin/phpunit.sh test/Policylead/Scraper/Parser/ArticleTitle/FromJsonTest.php
```

# Running the crawler


## through php

usage:
php -f ./bin/crawler.php -- --url=https://www.spiegel.de/politik/ --limit=5

parameters:

* **url**: Url either from an article list page or an article
* **limit**:  Limit the amount of articles to store in a single run

## through bin/crawler.sh 

usage:

./bin/crawler.sh [-d] -u 'https://www.spiegel.de/politik/' -l5 cmd-crawl

the previous is equivalent to 

parameters:

* **d**: to run it dockerized or not
* **u**: will set the url to begin the crawling
* **l**: will limit the amount of articles to store

