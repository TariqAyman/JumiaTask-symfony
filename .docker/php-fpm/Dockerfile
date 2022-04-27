FROM php:7.4-fpm

COPY wait-for-it.sh /usr/bin/wait-for-it
COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

RUN chmod +x /usr/bin/wait-for-it

RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    libsqlite3-dev \
    sqlite3 \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN docker-php-ext-configure gd --with-jpeg --with-freetype

RUN docker-php-ext-install \
    pdo pdo_mysql zip xsl gd intl opcache exif mbstring pdo_sqlite xml

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

CMD composer i -o ; wait-for-it db:5432 -- bin/console doctrine:migrations:migrate --no-interaction ;  php-fpm
CMD composer i -o ; wait-for-it db:5432 -- bin/console doctrine:fixtures:load --group=group1 --no-interaction ;  php-fpm
CMD composer i -o ; wait-for-it db:5432 -- chmod -R 777 var/cache/dev ;  php-fpm
CMD composer i -o ; wait-for-it db:5432 -- chmod -R 777 var/log ;  php-fpm

EXPOSE 9000
