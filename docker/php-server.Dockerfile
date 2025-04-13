FROM php:8.4-apache
SHELL ["/bin/bash", "-c"]
ADD --chmod=+x https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN apt update && apt full-upgrade -y\
    && apt install nodejs git 7zip -y\
    && apt clean\
    # install php extensions
    /usr/local/bin/install-php-extensions && \
    install-php-extensions mongodb xdebug
ENV DOCUMENT_ROOT=/app/public PROJECT_ROOT=/app PHPRC=/app/php.ini
RUN a2enmod rewrite headers
COPY /docker/server.conf /etc/apache2/sites-available/000-default.conf
COPY --chown=www-data:www-data --chmod=775 . ${PROJECT_ROOT}
RUN rm -r ${PROJECT_ROOT}/docker
# COPY --chmod=+x docker-entrypoint.sh /usr/local/bin/docker-entrypoint
# ENTRYPOINT ["docker-entrypoint"]
# CMD ["apache2-foreground"]