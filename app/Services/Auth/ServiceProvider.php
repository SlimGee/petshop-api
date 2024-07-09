<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Auth\Facades\JWT;
use App\Services\Auth\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

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

                    Token::where('unique_id', $payload['jti'])
                        ->first()
                        ->update(['last_used_at' => now()]);

                    return User::where('uuid', $payload['user_uuid'])->firstOrFail();
                } catch (\Throwable $e) {
                    return;
                }
            });
        });
    }
}
