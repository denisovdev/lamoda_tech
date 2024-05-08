#!/bin/bash

composer install --no-scripts --no-progress --no-interaction

bin/console d:m:m --no-interaction --allow-no-migration

php-fpm
