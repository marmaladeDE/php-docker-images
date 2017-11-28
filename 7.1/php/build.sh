#!/bin/bash

docker build \
	--pull \
	--tag webvariants/php:7.1 \
	--force-rm \
	--memory 2048MB \
	--memory-swap 4096MB \
	.
