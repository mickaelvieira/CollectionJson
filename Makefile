OS         := $(shell uname -s)
PATH       := bin:$(PATH)
SHELL      := /bin/bash
SOURCE_DIR := src

.PHONY: all clean install lint fmt test examples branch release

all: clean install

clean:
	rm -rf vendor/*

install: composer.json composer.lock
	composer install

lint:
	phpcs --standard=PSR2 --report=full $(SOURCE_DIR)

fmt:
	phpcbf --standard=PSR2 $(SOURCE_DIR)

test:
	phpspec run --format=pretty -vvv

examples:
	test-examples

branch:
	create-branch

release:
	create-release
