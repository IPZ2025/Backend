FROM php:8.4-apache
SHELL ["/bin/bash", "-c"]
ADD --chmod=+x https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
# RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
RUN apt update && apt full-upgrade -y\
    && apt install nodejs git 7zip -y\
    && apt clean\
    # install php extensions
    /usr/local/bin/install-php-extensions && \
    install-php-extensions mongodb xdebug
RUN a2enmod rewrite
COPY server.conf /etc/apache2/sites-available/000-default.conf
COPY --chmod=+x docker-entrypoint.sh /usr/local/bin/docker-entrypoint
ENTRYPOINT ["docker-entrypoint"]
CMD ["apache2-foreground"]