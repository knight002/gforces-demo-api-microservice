FROM php:7.3-fpm as base

# Install packages
RUN apt-get update && apt-get install -y autoconf pkg-config libssl-dev zip unzip git libgmp-dev

RUN docker-php-ext-install gmp \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli

# Setup composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
#RUN composer global require hirak/prestissimo --no-plugins --no-scripts

# this directory needs to be present and writable by the app
RUN mkdir /var/log/php-fpm && chown www-data:www-data /var/log/php-fpm
#RUN ln -s /dev/stderr /var/log/php-fpm/im-es.log  && chown -h www-data:www-data /var/log/php-fpm/im-es.log

#set pm.max_children
#RUN sed -i -e 's/^pm\.max_children = 5/pm\.max_children = 20/g' /usr/local/etc/php-fpm.d/www.conf

ARG APPLICATION_ENV

RUN if [[ ! -z "${APPLICATION_ENV:-}" ]] && [ $APPLICATION_ENV != "production" ]; then \
        cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini; \
else \
        cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini; \
fi;

#CMD bash -c "composer install -o --prefer-dist --no-progress --no-suggest --no-interaction"

# Dev environment doesn't run this stage or beyond
FROM base as build

ARG WITH_XDEBUG=false

RUN if [ $WITH_XDEBUG = "true" ] ; then \
        pecl install xdebug; \
        docker-php-ext-enable xdebug; \
        echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    fi ;

# Configure workspace
# APP_ROOT is referenced in production from a generic nginx config
ENV APP_ROOT /var/www/html
WORKDIR ${APP_ROOT}
COPY . ${APP_ROOT}

# Install dependencies
RUN composer install --no-interaction -o && rm -rf /root/.composer

# Copy public assets that are generated during composer install
ADD ./public ${APP_ROOT}/public

#db
COPY ./db/docker-entrypoint-initdb.d /docker-entrypoint-initdb.d/

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]

