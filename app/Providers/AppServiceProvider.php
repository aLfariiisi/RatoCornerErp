<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Tambahkan pengecekan env untuk memaksa HTTPS di Render
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        try {
            // Membagikan variabel $setting ke semua file view secara otomatis
            $setting = Setting::first();
            View::share('setting', $setting);
        } catch (\Exception $e) {
            // Dibungkus try-catch supaya tidak error saat menjalankan php artisan migrate
        }
    }
}