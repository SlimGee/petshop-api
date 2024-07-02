<?php

namespace App\Services\Auth;

use App\Services\Auth\Contracts\Storage;
use App\Services\Auth\Storage\Eloquent;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Storage::class, function () {
            return new Eloquent;
        });
    }
}
