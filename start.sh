#!/bin/bash

# Cache konfigurasi
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan migrasi
php artisan migrate --force

# -----------------------------------------------------
# TAMBAHKAN DUA BARIS INI UNTUK MEMPERBAIKI PERMISSION:
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
# -----------------------------------------------------

# Jalankan server web Apache
apache2-foreground