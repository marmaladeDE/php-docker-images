#!/bin/bash

docker build \
	--pull \
	--tag webvariants/php:5.6 \
	--force-rm \
	--memory 256MB \
	--memory-swap 512MB \
	.
