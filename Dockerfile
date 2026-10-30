FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install mysqli pdo_mysql \
    && a2enmod rewrite headers

# Allow .htaccess overrides
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Prevent Apache from exposing internal ports
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    echo "UseCanonicalName Off" >> /etc/apache2/apache2.conf && \
    echo "UseCanonicalPhysicalPort Off" >> /etc/apache2/apache2.conf

ENV PORT=8080
EXPOSE 8080

# Use Render's dynamic port
RUN sed -i 's/Listen .*/Listen ${PORT}/' /etc/apache2/ports.conf && \
    sed -i 's/<VirtualHost \*:[0-9]*>/<VirtualHost *:${PORT}>/' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

# Copy ALL directories
COPY assets ./assets
COPY images ./images
COPY images_usdt ./images_usdt
COPY vendors ./vendors
COPY jili ./jili
COPY pg ./pg
COPY pay ./pay
COPY api ./api
COPY admin ./admin
COPY serive ./serive
COPY database ./database
COPY selfservice ./selfservice
COPY tashangame ./tashangame
COPY Tashanveu ./Tashanveu
COPY jdb ./jdb
COPY jdbapi ./jdbapi
COPY jet ./jet
COPY plugins ./plugins
COPY manifest ./manifest

# Copy SPA entry point, all PHP files, and other root files
COPY index.html .
COPY *.php .
COPY *.svg .
COPY *.png .
COPY *.ico .
COPY .htaccess .
COPY php.ini .

RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

CMD ["/entrypoint.sh"]
