#!/bin/bash
set -e

./artisan cache:clear
./artisan config:cache
./artisan route:cache
./artisan migrate:fresh

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- apache2-foreground "$@"
fi

exec "$@"