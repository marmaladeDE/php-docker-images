#!/bin/bash

docker build \
	--pull \
	--tag webvariants/php:7.3 \
	--force-rm \
	--memory 256MB \
	--memory-swap 512MB \
	.
