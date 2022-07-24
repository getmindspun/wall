# Wall plugin for WordPress

Easy to use, lightweight plugin that keeps your site private from non-logged in users.

Any user that isn't logged in will be redirected to the login page or shown a custom landing page (configurable).

Using the custom 'X-Secret' HTTP Header, you can also view content as normally.  This header allows programmatic access to site content. 

## Development

### Requirements
* composer
* sass
* make

### Setup

```shell
composer update
./vendor/bin/phpcs --config-set installed_paths vendor/phpcompatibility/php-compatibility,vendor/phpcompatibility/phpcompatibility-wp,vendor/wp-coding-standards/wpcs
```

Verify with:
```shell
./vendor/bin/phpcs -i
```
