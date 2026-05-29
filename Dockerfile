FROM dunglas/frankenphp:1-php8.4

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

RUN install-php-extensions \
    pdo_mysql \
    redis \
    intl \
    zip \
    gd \
    bcmath \
    opcache \
    pcntl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker/frankenphp/Caddyfile /etc/caddy/Caddyfile

COPY . /app

RUN rm -rf bootstrap/cache/*.php \
    && composer install --no-interaction --optimize-autoloader --no-scripts \
    && chown -R www-data:www-data /app \
    && chmod -R 755 /app/storage /app/bootstrap/cache

EXPOSE 80

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
