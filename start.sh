#!/bin/bash

# Cache konfigurasi untuk performa production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan migrasi ke Supabase secara otomatis
php artisan migrate --force

# Jalankan server web Apache
apache2-foreground