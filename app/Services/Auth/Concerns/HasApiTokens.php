<?php

namespace App\Services\Auth\Concerns;

use App\Services\Auth\Facades\JWT;

trait HasApiTokens
{
    /*
     * @param array<string, string> $options
     */
    public function createToken(array $options = []): string
    {
        return JWT::encode($this, $options);
    }
}
