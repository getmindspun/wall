NAME := $(shell basename `pwd`)

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
	mkdir -p build
	zip -r build/$(NAME).zip *.php *.txt src templates assets
.PHONY: bundle
