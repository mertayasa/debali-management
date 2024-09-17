FROM alpine:latest

RUN adduser -D -u 1000 -g 1000 -s /bin/sh www && \
    mkdir -p /var/www/html && \
    chown -R www:www /var/www/html

RUN apk --no-cache add nginx \
        ca-certificates \
        curl \
        supervisor \
        php82 \
        php82-fpm \
        php82-apcu \
        php82-bcmath \
        php82-bz2 \
        php82-cgi \
        php82-ctype \
        php82-curl \
        php82-dom \
        php82-ftp \
        php82-gd \
        php82-iconv \
        php82-json \
        php82-mbstring \
        # php82-pecl-oauth \
        php82-opcache \
        php82-openssl \
        php82-pcntl \
        php82-fileinfo \
        php82-pecl-msgpack \
        php82-pdo \
        php82-pdo_mysql \
        php82-phar \
        php82-exif \
        php82-redis \
        php82-mysqli \
        php82-session \
        php82-simplexml \
        php82-xmlreader \
        php82-tokenizer \
        php82-xdebug \
        php82-xml \
	php82-intl \
        php82-xmlwriter \
        php82-zip
        # php82-zlib --repository http://nl.alpinelinux.org/alpine/edge/testing/

RUN ln -s -f /usr/bin/php82 /usr/bin/php
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN rm -rf /var/cache/apk/*

# Configure PHP-FPM
COPY docker-config/fpm-pool.conf /etc/php82/php-fpm.d/www.conf

# Configure supervisord
COPY docker-config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Setup document root
RUN mkdir -p /var/www/html

# Make sure files/folders needed by the processes are accessable when they run under the www user
RUN chown -R www.www /run && \
  chown -R www.www /var/lib/nginx && \
  chown -R www.www /var/log/nginx

# Switch to use a non-root user from here on
USER www

# Add application
WORKDIR /var/www/html
# COPY --chown=www src/ /var/www/html/

# Expose the port nginx is reachable on
EXPOSE 8080
# EXPOSE 8000 -> if you want to use artisan serve

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
# CMD ["php artisan serve"] -> if you want to use artisan serve
# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping
