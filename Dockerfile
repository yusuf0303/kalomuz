FROM laravelsail/php83-composer

WORKDIR /var/www/html

COPY . .

# PHP kengaytmalarni o‘rnatish
RUN docker-php-ext-install pdo_mysql

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

