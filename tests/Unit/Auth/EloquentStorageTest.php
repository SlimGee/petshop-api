<?php

namespace Tests\Unit\Auth;

use Tests\TestCase;

class EloquentStorageTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_can_add_entry_to_storage(): void
    {
        $identifier = bin2hex(random_bytes(16));

        $storage = new \App\Services\Auth\Storage\Eloquent();

        $storage->add($identifier);

        $this->assertDatabaseHas('blacklist_entries', [
            'identifier' => $identifier,
        ]);
    }

    public function test_can_confirm_entry_in_storage(): void
    {
        $identifier = bin2hex(random_bytes(16));

        $storage = new \App\Services\Auth\Storage\Eloquent();
        $storage->add($identifier);

        $this->assertTrue($storage->has($identifier));
        $this->assertFalse($storage->has(bin2hex(random_bytes(16))));
    }
}
