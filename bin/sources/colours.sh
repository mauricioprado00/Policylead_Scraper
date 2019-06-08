#!/usr/bin/env bash

color_always_param=''

function define_colors() {
    red=$(tput setaf 1)
    green=$(tput setaf 2)
    yellow=$(tput setaf 3)
    blue=$(tput setaf 4)
    magenta=$(tput setaf 5)
    cyan=$(tput setaf 6)
    reset=$(tput sgr0)
    bold=$(tput bold)
}

function color_always() {
    define_colors
    color_always_param='--color=always'
}

# Set up a nice prompt
# Does this TERM support color?
ncolors=$(tput colors 2>/dev/null)
if [ -n "$ncolors" ] && [ $ncolors -ge 8 ]
then
    define_colors
else
        red=''
        green=''
        yellow=''
        blue=''
        magenta=''
        cyan=''
        reset=''
        bold=''
fi

for param in ${BASH_ARGV[*]}; do
    if [ "$param" = "--color=always" ]; then
        color_always
    fi
done
