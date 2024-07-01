<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_new_users_can_register(): void
    {
        $this->withoutExceptionHandling();

        $password = $this->faker->password(8);
        $count = User::count();

        $response = $this->post('/api/v1/user/create', [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password,
            'address' => $this->faker->address(),
            'phone_number' => $this->faker->e164PhoneNumber(),
            'is_marketing' => $this->faker->randomElement([true, false]),
            'avatar' => $this->faker->uuid(),
        ]);

        $this->assertEquals($count + 1, User::count());

        $response->assertCreated();
    }
}
