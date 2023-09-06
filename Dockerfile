# CARGAMOS IMAGEN DE PHP MODO ALPINE SUPER REDUCIDA
FROM elrincondeisma/octane:latest

RUN curl -sS https://getcomposer.org/installer​ | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=spiralscout/roadrunner:2.4.2 /usr/bin/rr /usr/bin/rr

WORKDIR /app
COPY . .
RUN rm -rf /app/vendor
RUN rm -rf /app/composer.lock
RUN composer install
# RUN composer require laravel/octane spiral/roadrunner
COPY .env.example .env
RUN mkdir -p /app/storage/logs
RUN php artisan cache:clear
RUN php artisan view:clear
RUN php artisan config:clear
RUN php artisan l5-swagger:generate
RUN php artisan migrate:fresh --seed
# RUN php artisan octane:install --server="swoole"
# CMD php artisan serve --host="0.0.0.0" --port=8002 && php artisan websockets:serve --port=6001
CMD php artisan serve --host="0.0.0.0" --port=8002

EXPOSE 8002