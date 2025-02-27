# Официальный образ PHP
FROM php:8.2-cli

# Необходимые зависимости для работы образа Linux
RUN apt-get update && apt-get install -y \
    supervisor \
    sqlite3 \
    cron \
    nano \
    libzip-dev \
    unzip \
    && docker-php-ext-install pcntl \
    && pecl install redis \
    && rm -rf /var/lib/apt/lists/*

# Копируем файлы проекта в контейнер
COPY . /var/www/html

# Зависимости Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN cd /var/www/html && composer require predis/predis && composer require psr/simple-cache && composer install  # Устанавливаем пакет predis/predis, библиотеку psr/simple-cache и обновляем зависимости

# Копируем конфигурацию Supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Команда для запуска Supervisor
CMD ["/usr/bin/supervisord"]


