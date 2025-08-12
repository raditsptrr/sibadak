<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $this->call([
        AdminUserSeeder::class,
        KabupatenKotaSeeder::class,
        KabupatenKotaSeeder::class,
        CategoryIndicatorSeeder::class,
        StatisticValueSeeder::class, // Tambahkan ini di akhir
    ]);
    
}
}
