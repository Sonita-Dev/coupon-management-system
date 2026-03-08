FROM composer:2 AS composer_deps
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader --no-scripts
COPY . .

FROM node:20-alpine AS frontend_build
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources ./resources
COPY public ./public
COPY vite.config.js postcss.config.js tailwind.config.js ./
RUN npm run build

FROM php:8.3-cli-alpine
RUN apk add --no-cache bash \
    && apk add --no-cache mariadb-connector-c libpq oniguruma \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS postgresql-dev mariadb-connector-c-dev oniguruma-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring bcmath \
    && apk del .build-deps

WORKDIR /var/www/html
COPY --from=composer_deps /app ./
COPY --from=frontend_build /app/public/build ./public/build
COPY docker/start.sh /usr/local/bin/start

RUN chmod +x /usr/local/bin/start \
    && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

USER www-data
EXPOSE 10000

CMD ["start"]
