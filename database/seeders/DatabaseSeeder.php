<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //

        $this->call([
            OrderStatusSeeder::class,
            PostSeeder::class,
            PromotionSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
        ]);
    }
}
