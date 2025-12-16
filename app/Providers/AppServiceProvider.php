<?php

namespace App\Providers;

use App\Models\Divisi;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('*', function ($view) {
            $logoSetting = Setting::where('key', 'logo')->first();
            $logoUrl = ($logoSetting && $logoSetting->value) 
                        ? \Illuminate\Support\Facades\Storage::url($logoSetting->value) 
                        : asset('assets/image/logo_hima.png');

            $view->with('semua_divisi', Divisi::all());
            $view->with('logo', $logoSetting); // Kembalikan variabel $logo
            $view->with('logoUrl', $logoUrl); // Tetap bagikan $logoUrl
        });
    }
}
