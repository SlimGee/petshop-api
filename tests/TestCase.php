<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase, WithFaker;

    public function authenticated(): self
    {
        $user = User::factory()->create();

        return $this->withHeaders([
            'Authorization' => 'Bearer '.$user->createToken(),
        ]);
    }

    public function authenticatedAs(User $user): self
    {
        return $this->withHeaders([
            'Authorization' => 'Bearer '.$user->createToken(),
        ]);
    }
}
