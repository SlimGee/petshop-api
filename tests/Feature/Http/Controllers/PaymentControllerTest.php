<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Payment;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_list_all_payments(): void
    {
        Payment::factory(20)->create();

        $response = $this->authenticated()->getJson('/api/v1/payments');

        $response->assertOk();
    }

    public function test_can_create_new_payment(): void
    {
        $data = Payment::factory()->make()->toArray();
        $count = Payment::count();

        $response = $this->authenticated()->postJson('/api/v1/payments/create', $data);

        $response->assertCreated();

        $this->assertEquals($count + 1, Payment::count());
    }

    public function test_can_fetch_a_single_payment(): void
    {
        $payment = Payment::factory()->create();

        $response = $this->authenticated()->getJson("/api/v1/payment/{$payment->uuid}");

        $response->assertOk();

        $this->assertEquals($payment->uuid, $response->json('data.uuid'));
    }

    public function test_can_update_existing_payment(): void
    {
        $payment = Payment::factory()->create();
        $data = Payment::factory()->make()->toArray();

        $response = $this->authenticated()->patchJson("/api/v1/payment/{$payment->uuid}", $data);

        $response->assertOk();
    }

    public function test_can_delete_payment(): void
    {
        $payment = Payment::factory()->create();

        $response = $this->authenticated()->deleteJson("/api/v1/payment/{$payment->uuid}");

        $response->assertNoContent();
        $this->assertModelMissing($payment);
    }
}
