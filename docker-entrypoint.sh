#!/bin/bash
set -e

# Встановлюємо правильні права доступу для Laravel
chown -R www-data:www-data ${PROJECT_ROOT}/storage
chown -R www-data:www-data ${PROJECT_ROOT}/bootstrap/cache
chmod -R 775 ${PROJECT_ROOT}/storage
chmod -R 775 ${PROJECT_ROOT}/bootstrap/cache

# Виконуємо основну команду
exec "$@"