#!/bin/bash

filename=$(basename "$1")
extension="${filename##*.}"
if [ "$extension" == "cpp" ]; then
	g++ -Wall -c $filename 2> $filename.log
fi

if [ "$extension" == "c" ]; then
	gcc -Wall -c $filename 2> $filename.log
fi
