# PHP 8.1 + Apache — версия, совместимая с Bitrix CMS
FROM php:8.2-apache

# Системные зависимости
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libxml2-dev \
    libicu-dev \
    libcurl4-openssl-dev \
    libonig-dev \
    libmemcached-dev \
    zlib1g-dev \
    unzip \
    curl \
    && rm -rf /var/lib/apt/lists/*

# PHP-расширения, обязательные для Bitrix
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        gd \
        mbstring \
        mysqli \
        pdo \
        pdo_mysql \
        zip \
        xml \
        soap \
        intl \
        opcache \
        bcmath \
        sockets \
        exif

# Memcache (опционально, но Bitrix его любит)
RUN pecl install memcached \
    && docker-php-ext-enable memcached

# php.ini для Bitrix
RUN echo "memory_limit = 256M"          >> /usr/local/etc/php/conf.d/bitrix.ini \
    && echo "max_execution_time = 300"  >> /usr/local/etc/php/conf.d/bitrix.ini \
    && echo "max_input_vars = 10000"    >> /usr/local/etc/php/conf.d/bitrix.ini \
    && echo "upload_max_filesize = 100M">> /usr/local/etc/php/conf.d/bitrix.ini \
    && echo "post_max_size = 100M"      >> /usr/local/etc/php/conf.d/bitrix.ini \
    && echo "short_open_tag = On"       >> /usr/local/etc/php/conf.d/bitrix.ini \
    && echo "mbstring.func_overload = 0" >> /usr/local/etc/php/conf.d/bitrix.ini \
    && echo "default_charset = UTF-8" >> /usr/local/etc/php/conf.d/bitrix.ini \
    && echo "date.timezone = Europe/Moscow"      >> /usr/local/etc/php/conf.d/bitrix.ini \
    # OPcache — Bitrix требует validate_timestamps=1 для dev
    && echo "opcache.enable = 1"                 >> /usr/local/etc/php/conf.d/bitrix.ini \
    && echo "opcache.validate_timestamps = 1"    >> /usr/local/etc/php/conf.d/bitrix.ini \
    && echo "opcache.revalidate_freq = 0"        >> /usr/local/etc/php/conf.d/bitrix.ini

# Включить нужные модули Apache
RUN a2enmod rewrite headers expires deflate

# Конфиг Apache
COPY apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Исправить права на директорию сессий
RUN mkdir -p /var/lib/php/sessions \
    && chown -R www-data:www-data /var/lib/php/sessions \
    && chmod 770 /var/lib/php/sessions

RUN echo "session.save_path = /tmp" >> /usr/local/etc/php/conf.d/bitrix.ini \
    && chmod 1777 /tmp

WORKDIR /var/www/html

# Все файлы в html должны принадлежать www-data
RUN chown -R www-data:www-data /var/www/html
