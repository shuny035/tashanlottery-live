FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install mysqli pdo_mysql \
    && a2enmod rewrite headers

ENV PORT=8080
EXPOSE 8080

# Write a complete, clean Apache VirtualHost config with all rewrite rules baked in
RUN cat > /etc/apache2/sites-available/000-default.conf << 'APACHECONF'
<VirtualHost *:${PORT}>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html

    <Directory /var/www/html>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted

        # Serve existing files/directories directly
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} -f [OR]
        RewriteCond %{REQUEST_FILENAME} -d
        RewriteRule ^ - [L]

        # Never SPA-fallback for backend directories or PHP files
        RewriteCond %{REQUEST_URI} ^/(api|admin|pay|pg|jili|assets|images|images_usdt|vendors|uploads|database|selfservice|tashangame|Tashanveu|jdb|jdbapi|jet|plugins|serive|manifest)(/|$) [NC]
        RewriteRule ^ - [L]

        RewriteCond %{REQUEST_URI} \.php$ [NC]
        RewriteRule ^ - [L]

        # SPA fallback for all frontend routes
        RewriteRule ^.*$ /index.html [L]
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
APACHECONF

# Set the port Apache listens on
RUN echo "Listen \${PORT}" > /etc/apache2/ports.conf

# Prevent Apache from exposing internal ports
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Enable required modules
RUN a2enmod rewrite headers

# Copy our custom Apache VirtualHost config BEFORE files
COPY apache-tashan.conf /etc/apache2/sites-available/000-default.conf

# Make sure AllowOverride All is set for the html dir
RUN echo '<Directory /var/www/html>\n    AllowOverride All\n    Require all granted\n</Directory>' >> /etc/apache2/apache2.conf

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
COPY php.ini .

RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

CMD ["/entrypoint.sh"]
