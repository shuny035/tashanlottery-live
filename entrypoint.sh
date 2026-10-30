#!/bin/bash
set -e

# Set default port if not provided by Render
PORT="${PORT:-8080}"
echo "Configuring Apache to listen on port ${PORT}..."

# Set port in ports.conf and virtualhost at runtime
sed -i "s/Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:[^>]*>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Start game engine daemon in background
echo "Starting Game Engine Daemon in background..."
php /var/www/html/game_engine.php &

# Start Apache in foreground
echo "Starting Apache Web Server on port ${PORT}..."
exec apache2-foreground
