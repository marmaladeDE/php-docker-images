#!/bin/bash

docker build \
	--pull \
	--tag webvariants/php:7.2 \
	--force-rm \
	--memory 256MB \
	--memory-swap 512MB \
	.
