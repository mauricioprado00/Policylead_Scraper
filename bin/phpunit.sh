#!/usr/bin/env bash

image_name=php:7-cli
#image_name=php:5.5-cli
function pull_php7_image()
{
    docker pull ${image_name}
}

if [[ "$(docker images -q ${image_name} 2> /dev/null)" == "" ]]; then
  pull_php7_image
fi

USER=$(id -u)
GROUP=$(id -g)

params=$(echo $@)
docker run --rm -u="$USER:$GROUP" -v $(pwd):/app ${image_name} sh -c "cd /app; /app/vendor/bin/phpunit $params"
