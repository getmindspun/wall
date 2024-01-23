PWD := $(shell basename `pwd`)
NAME := $(shell basename $$(PWD))
VERSION = $(shell awk '/Version:/ {printf "%s", $$3}' $$(PWD)/wall.php)

all: lint scss
.PHONY: all

scss:
	sass scss/style.scss:assets/css/style.css --style compressed
.PHONY: scss

lint:
	php vendor/bin/phpcbf || [ $$? -eq 1 ]
	php vendor/bin/phpcs
.PHONY: lint

bundle: all
	mkdir -p build && rm -f build/$(NAME).zip
	zip -r build/$(NAME).zip *.php *.txt src templates assets -x "**/.DS_Store"
.PHONY: bundle

svn_trunk: bundle
	cd svn/trunk && unzip -o ../../build/$(NAME).zip
.PHONY: svn_trunk

svn_version: bundle
	cd svn && svn cp trunk tags/$(VERSION)
.PHONY: svn_version
