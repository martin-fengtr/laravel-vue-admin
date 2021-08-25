FROM composer as composer
WORKDIR /var/www
COPY . .
RUN composer install --ignore-platform-reqs

#FROM tain/nginx-phpfpm
FROM gitlab.spb.net.ru:5005/system/nginx-phpfpm:php74

MAINTAINER Alex Sh <freezko@gmail.com>

ARG APP_ENV
ENV APP_ENV=$APP_ENV

WORKDIR /var/www

COPY . .
COPY .env.${APP_ENV} .env
COPY --from=composer /var/www/vendor ./vendor/

RUN touch /var/www/storage/logs/laravel.log
RUN chown -R 1000:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache
RUN cd /var/www/
RUN npm i && npm run dev
RUN php artisan migrate