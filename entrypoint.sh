#!/bin/bash
set -e

# Start game engine daemon in background
echo "Starting Game Engine Daemon in background..."
php /var/www/html/game_engine.php &

# Start Apache in foreground
echo "Starting Apache Web Server..."
exec apache2-foreground
