#!/bin/bash
set -euo pipefail

# SurveyKita Production VPS Setup Script
# Tested on: Debian 12 (Bookworm) Azure VM
# Stack: Caddy + Laravel Octane (FrankenPHP) + MariaDB + Queue Worker

APP_DIR="/var/www/surveykita"
APP_USER="azureuser"

echo "==> Updating system..."
sudo apt update && sudo apt upgrade -y

echo "==> Installing dependencies..."
sudo apt install -y software-properties-common curl git unzip python3 acl

echo "==> Adding PHP 8.5 PPA..."
sudo add-apt-repository -y ppa:ondrej/php
sudo apt update

echo "==> Installing PHP 8.5 + extensions..."
sudo apt install -y php8.5 php8.5-fpm php8.5-cli php8.5-mbstring php8.5-xml php8.5-curl \
  php8.5-mysql php8.5-sqlite3 php8.5-gd php8.5-intl php8.5-zip php8.5-bcmath \
  php8.5-readline php8.5-opcache php8.5-dom php8.5-exif php8.5-lexbor

echo "==> Installing MariaDB..."
sudo apt install -y mariadb-server mariadb-client
sudo systemctl enable --now mariadb

echo "==> Securing MariaDB..."
sudo mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED BY 'changeme';"
sudo mysql -e "DELETE FROM mysql.user WHERE User='';"
sudo mysql -e "DROP DATABASE IF EXISTS test;"
sudo mysql -e "FLUSH PRIVILEGES;"

echo "==> Creating database and user..."
sudo mysql -e "CREATE DATABASE IF NOT EXISTS surveykita CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
sudo mysql -e "CREATE USER IF NOT EXISTS 'surveykita'@'127.0.0.1' IDENTIFIED BY 'ESEmB9E7X1LrpOwoaWCVnkyjhEEZJcAg';"
sudo mysql -e "GRANT ALL PRIVILEGES ON surveykita.* TO 'surveykita'@'127.0.0.1';"
sudo mysql -e "FLUSH PRIVILEGES;"

echo "==> Installing Caddy..."
sudo apt install -y caddy

echo "==> Installing Node.js (for Bun)..."
curl -fsSL https://bun.sh/install | bash

echo "==> Installing Composer..."
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

echo "==> Setting up application directory..."
sudo mkdir -p "$APP_DIR"
sudo chown -R "$APP_USER:www-data" "$APP_DIR"
sudo chmod -R 775 "$APP_DIR"
sudo setfacl -R -d -m u:"$APP_USER":rwx -m g:www-data:rwx "$APP_DIR"

echo "==> Cloning/pulling code..."
cd "$APP_DIR"
if [ -d .git ]; then
  git pull
else
  sudo -u "$APP_USER" git clone <REPO_URL> .
fi

echo "==> Installing PHP dependencies..."
sudo -u "$APP_USER" composer install --no-dev --optimize-autoloader

echo "==> Setting up environment..."
if [ ! -f .env ]; then
  cp deployment/env.production .env
fi

echo "==> Running migrations..."
sudo -u "$APP_USER" php artisan migrate --force

echo "==> Building frontend assets..."
sudo -u "$APP_USER" bun install
sudo -u "$APP_USER" bun run build

echo "==> Caching config..."
sudo -u "$APP_USER" php artisan config:cache
sudo -u "$APP_USER" php artisan route:cache
sudo -u "$APP_USER" php artisan view:cache

echo "==> Installing Caddyfile..."
sudo cp deployment/Caddyfile /etc/caddy/Caddyfile
sudo systemctl reload caddy

echo "==> Installing systemd services..."
sudo cp deployment/surveykita-octane.service /etc/systemd/system/
sudo cp deployment/surveykita-queue.service /etc/systemd/system/
sudo systemctl daemon-reload
sudo systemctl enable --now surveykita-octane
sudo systemctl enable --now surveykita-queue

echo "==> Setting up cron (scheduler)..."
(sudo -u "$APP_USER" crontab -l 2>/dev/null; echo "* * * * * cd $APP_DIR && php artisan schedule:run >> /dev/null 2>&1") | sudo -u "$APP_USER" crontab -

echo "==> Setup complete!"
echo "    Domain: https://tiga.yehezkiedio.my.id"
echo "    Octane: systemctl status surveykita-octane"
echo "    Queue:  systemctl status surveykita-queue"
echo "    Caddy:  systemctl status caddy"
echo "    Logs:   tail -f $APP_DIR/storage/logs/laravel.log"
