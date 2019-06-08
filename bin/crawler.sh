#!/usr/bin/env bash

source $(dirname $0)/sources/common.sh
depends sources/docker sources/colours sources/mutex local/aliases local/paths

dockerized=no

url=''
allargs=$@
all_arguments=$@
exclusive=crawler
image_name=php:7-cli
#image_name=php:5.6-cli

function cmd-help() {
    echo "Spiegel Crawler"
    echo
    echo "USAGE:"
    echo "  crawler.sh <options> <commands>"
    echo
    echo "  <commands>:                 <command> [<commands>]"
    echo 
    echo "  <options>:                  <option> [<options>]"
    echo 
    echo "  <option>:                   -<option-code> [<option-value>]"
    echo
    echo "  <option-value>:             valid string value specified in option"
    echo
    echo "  <option-code>:              any of the following list"
    echo 
    echo "          d:                  from docker container."
    echo "          p:                  run without docker"
    echo 
    echo "  <command>:"
    echo "          cmd-help            Prints the help"
    echo "          cmd-crawl           Runs the crawling task"
    echo "          cmd-run             Runs the crawling with default parameters"
    echo 
}

function create_prompt_color() {
  echo -e '\033[0;'${1}'m'
}

function pull_php7_image()
{
    docker pull ${image_name}
}

function cmd-crawl() {
    if [ ${dockerized} = "yes" ]; then
        dockerception
    else
        crawl
    fi
}

function dockerception() {
    local arguments=$(echo $allargs | sed 's#-d\s*##g')
    if [[ "$(docker images -q ${image_name} 2> /dev/null)" == "" ]]; then
      pull_php7_image
    fi
    
    USER=$(id -u)
    GROUP=$(id -g)
    
    pushd $(dirname $0)/.. >/dev/null
    docker run --rm -u="$USER:$GROUP" -v $(pwd):/app ${image_name} sh -c "cd /app; ./bin/crawler.sh $arguments"
    popd >/dev/null
}

function crawl() {
    local crawlscript=$(dirname $0)/crawler.php
    local params=""
    
    if [ -n "${url}" ]; then
        params="$params --url=${url}"
    fi
        
    php -f ${crawlscript} -- $params
}

function cmd-run() {
    url=https://www.spiegel.de/politik/
    cmd-crawl
}


function init-exclusive-named-process() {
    local LOCKFILE=$(rpath $(dirname $0)/../var)/lock/mutex-${exclusive}.flag
    local result
    
    mutex ${LOCKFILE}
    result=$?
    
    if [ ${result} -ne 0 ]; then
        echo "Proccess ${LOCKFILE} is already running! (returned code ${result})"
        exit 90
    fi
    
    $0 $(echo ${all_arguments} | sed 's#-x '$exclusive'##g')
    exit $?
}


while getopts "h?dpu:x:" opt; do
    case "$opt" in
    h|\?)
        ;;
    p)
        dockerized=no
        ;;
    d)
        dockerized=yes
        ;;
    u)
        url="$OPTARG"
        ;;
    x)
        exclusive="$OPTARG"
        init-exclusive-named-process
        ;;
    esac
done


for var in "$@"
do
    if [[ $var = cmd* ]]; then
        $var
    fi
done

if [ $# = 0 ]; then cmd-help; fi
exit 0

