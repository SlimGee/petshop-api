<?php

namespace App\Services\Auth\Contracts;

use Carbon\Carbon;

interface Storage
{
    public function has(string $id): bool;

    public function add(string $id, ?Carbon $expiresAt = null): void;
}
