<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Models\DataSekolah;

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
    // Middleware
    Route::aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);
    Route::aliasMiddleware('siswa', \App\Http\Middleware\SiswaMiddleware::class);

    // Share data sekolah ke semua view
    View::composer('*', function ($view) {
        $dataSekolah = DataSekolah::first(); // Ambil satu baris data
        $view->with('dataSekolah', $dataSekolah);
    });
}
}
