<?php

namespace App\Providers;

use App\Models\Event;
use Illuminate\Auth\Access\Gate;
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
        \Illuminate\Support\Facades\Gate::define('update-event', function ($user, Event $event) {
            return $user->id === $event->user_id;
        });
    }
}
