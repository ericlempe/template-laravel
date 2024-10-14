<?php

namespace App\Providers;

use App\Enums\Can;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
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

        foreach (Can::cases() as $can) {
            Gate::define(
                str($can->value)->snake('-')->toString(),
                fn (User $user) => $user->hasPermissionTo($can)
            );
        }
    }
}
