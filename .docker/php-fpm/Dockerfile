# Используем образ PHP-FPM
FROM php:8.3-fpm

# Обновляем текущие пакеты и устанавливаем необходимые
RUN apt-get update && apt-get install -y \
    curl \
    wget \
    unzip

# Установка расширений PHP
RUN docker-php-ext-install pdo pdo_mysql

# Скачиваем установщик Composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

# Переносим нашу конфигурацию php-fpm внутрь контейнера
COPY ./conf.d /usr/local/etc/php/conf.d/

# Устанавливаем рабочую директорию
WORKDIR /var/www