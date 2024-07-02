<?php

namespace App\Services\Auth\Storage;

use App\Services\Auth\Contracts\Storage;
use App\Services\Auth\Storage\Eloquent\Entry;
use Carbon\Carbon;

class Eloquent implements Storage
{
    /**
     * Check if the storage has a specific identifier.
     */
    public function has(string $id): bool
    {
        return Entry::where('identifier', $id)->exists();
    }

    /**
     * Add an identifier to the storage.
     */
    public function add(string $id, ?Carbon $expiresAt = null): void
    {
        Entry::create([
            'identifier' => $id,
            'expires_at' => $expiresAt,
        ]);
    }
}
