#!/bin/bash

set -e
    cd /var/www/html
    composer install
exec "$@"
