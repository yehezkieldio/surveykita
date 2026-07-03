# SurveyKita Production Deployment

Azure VM `vm-surveykita-tiga` (indonesiacentral)
IP: 48.193.44.197
SSH: `azureuser@48.193.44.197`

## Stack

- **Web Server**: Caddy (auto-HTTPS via Let's Encrypt)
- **App Server**: Laravel Octane with FrankenPHP (port 8000)
- **Database**: MariaDB 10.11
- **Queue**: Laravel Queue Worker (database driver)
- **PHP**: 8.5
- **Frontend**: Bun + Vite

## Architecture

```
Internet → Caddy (:443) → reverse_proxy → Octane/FrankenPHP (:8000)
                                           ↕
                                       MariaDB (127.0.0.1:3306)
                                           ↕
                                    Queue Worker (database)
```

Caddy handles TLS termination, compression (zstd/gzip), and reverse proxies to FrankenPHP which runs Laravel Octane in worker mode.

## Files

| File | Purpose |
|------|---------|
| `Caddyfile` | Caddy reverse proxy config |
| `surveykita-octane.service` | Octane/FrankenPHP systemd service |
| `surveykita-queue.service` | Queue worker systemd service |
| `mariadb-50-server.cnf` | MariaDB server config |
| `env.production` | Production .env (secrets included — keep private) |
| `setup.sh` | Fresh VPS provisioning script |

## Octane Configuration

- Server: FrankenPHP
- Workers: 2
- Max requests per worker: 500
- Admin port: 2020
- HTTPS: enabled (via Caddy TLS termination)
- Garbage collection threshold: 50MB
- Max execution time: 30s

## Queue Worker

- Driver: database
- Sleep: 3s between jobs
- Tries: 3
- Timeout: 90s per job
- Max time: 3600s (1 hour, then worker restarts)

## Commands

```bash
# Service management
sudo systemctl status surveykita-octane
sudo systemctl restart surveykita-octane
sudo systemctl status surveykita-queue
sudo systemctl restart surveykita-queue
sudo systemctl status caddy

# Logs
tail -f /var/www/surveykita/storage/logs/laravel.log
sudo journalctl -u surveykita-octane -f

# Database
mysql -u surveykita -p surveykita

# Deploy
cd /var/www/surveykita
git pull
composer install --no-dev --optimize-autoloader
bun install && bun run build
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
sudo systemctl restart surveykita-octane
```

## Domain

- Production: `https://tiga.yehezkiedio.my.id`
- DNS: A record → 48.193.44.197
- TLS: Auto via Caddy/Let's Encrypt
