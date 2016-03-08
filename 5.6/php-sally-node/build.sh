#!/bin/bash

docker build \
	--tag webvariants/php-sally-node:5.6 \
	--force-rm \
	--memory 256MB \
	--memory-swap 512MB \
	.
