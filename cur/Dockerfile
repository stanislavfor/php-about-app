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
    && rm -rf /var/lib/apt/lists/*

# Копируем файлы проекта в контейнер
COPY . /var/www/html

# Зависимости Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN cd /var/www/html && composer install

# Копируем конфигурацию Supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Команда для запуска Supervisor
CMD ["/usr/bin/supervisord"]


