<?php

namespace App\Providers;

use App\Models\Gaji;
use App\Policies\GajiPolicy;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Carbon::setLocale('id');
        Paginator::useBootstrapFive();

        // Proteksi akses gaji
        Gate::policy(Gaji::class, GajiPolicy::class);
    }
}