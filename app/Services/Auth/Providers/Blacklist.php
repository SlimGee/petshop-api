<?php

namespace App\Services\Auth\Providers;

use App\Services\Auth\Contracts\Storage;
use Carbon\Carbon;

class Blacklist
{
    public function __construct(private Storage $storage) {}

    public function has(string $id): bool
    {
        return $this->storage->has($id);
    }

    public function add(string $id, ?Carbon $expiresAt = null): void
    {
        $this->storage->add($id, $expiresAt);
    }
}
