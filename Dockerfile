FROM php:8.3-cli

RUN apt-get update && apt-get install -y libzip-dev unzip libicu-dev \
    && docker-php-ext-install pdo pdo_mysql zip bcmath intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /app
COPY . .

CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"]
