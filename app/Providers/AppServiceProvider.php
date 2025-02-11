<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Tarea;


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
        Gate::define('admin_access', function (User $user) {
            return $user->is_admin; // Solo permite acceso si is_admin es true
        });
        
        Gate::define('manage', function (User $user, Tarea $tarea) {
          return $user->is_admin || $tarea->creador_id === $user->id;
        });
    }
}
