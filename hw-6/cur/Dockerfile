# Официальный образ PHP
FROM php:8.2-cli

# Необходимые зависимости для работы образа Linux
RUN apt-get update && \
    apt-get install -y \
        supervisor \
        sqlite3 \
        cron \
        nano \
        libzip-dev \
        unzip \
        rabbitmq-server && \
    docker-php-ext-install pcntl && \
    pecl install redis && \
    rm -rf /var/lib/apt/lists/* && \
    rabbitmq-plugins enable rabbitmq_management && \
    echo '[{rabbit, [{loopback_users, []}]}].' > /etc/rabbitmq/rabbitmq.config

# Копируем файлы проекта в контейнер
COPY . /var/www/html

# Зависимости Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка php-amqplib/php-amqplib
RUN cd /var/www/html && composer require php-amqplib/php-amqplib

# Остальные зависимости Composer
RUN cd /var/www/html && \
    composer require predis/predis && \
    composer require psr/simple-cache && \
    composer install

# Копируем конфигурацию Supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Команда для запуска Supervisor
CMD ["/usr/bin/supervisord"]


