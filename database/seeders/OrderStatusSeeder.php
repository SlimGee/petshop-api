<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(['open', 'pending payment', 'paid', 'shipped', 'cancelled'])
            ->each(fn (string $status) => OrderStatus::firstOrcreate([
                'title' => $status,
            ]));
    }
}
