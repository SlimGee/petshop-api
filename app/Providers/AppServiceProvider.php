<?php

namespace App\Providers;

use App\Models\User;
use App\Services\Auth\Facades\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        Auth::resolved(function ($auth) {
            $auth->viaRequest('jwt', function (Request $request) {
                try {
                    $token = $request->bearerToken();

                    if (empty($token)) {
                        return;
                    }

                    $payload = JWT::decode($token, true);

                    return User::where('uuid', $payload['user_uuid'])->firstOrFail();

                } catch (\Throwable $e) {
                    return;
                }
            });
        });
    }
}
