<?php

namespace App\Services\Auth\Concerns;

use App\Services\Auth\Facades\JWT;

trait HasApiTokens
{
    public function createToken(): string
    {
        return JWT::encode(['user_uuid' => $this->uuid]);
    }
}
