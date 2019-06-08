#!/usr/bin/env bash

function docker-container-status() {
    local name=$1
    echo $(docker-compose ps | grep $name | awk '{print $4}')
}

function docker-container-status-is-up() {
    local name=$1
    local status=$(docker-container-status $name)
    
    if [ "$status" != "Up" ]; then
        return 1
    fi

    return 0
}

function docker-container-name() {
    local name=$1
    echo $(docker-compose ps | grep $name | awk '{print $1}')
}

function docker-container-id() {
    local name=$(get_docker_container_name $1)
    echo $(docker ps | grep $name | awk '{print $1}')
}

# aliases for backward compatibility
function is_docker_running() { docker-container-status-is-up $@; } 
function get_docker_container_name() { docker-container-name $@; }
function get_docker_container_id() { docker-container-id $@; }
function get_docker_status() { docker-container-status $@; }
