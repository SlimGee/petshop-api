<?php

namespace Tests\Unit\Auth;

use App\Services\Auth\Contracts\Storage;
use App\Services\Auth\Providers\Blacklist;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class BlacklistTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_can_add_item_to_blacklist(): void
    {
        $mock = $this->createMock(Storage::class, function (MockInterface $mock) {
            $mock->shouldReceive('add')->once();
        });

        $id = bin2hex(random_bytes(16));

        $mock->expects($this->once())
            ->method('add')
            ->with($id, null);

        $blacklist = new Blacklist($mock);

        $blacklist->add($id);
    }
}
