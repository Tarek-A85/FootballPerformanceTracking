<?php

namespace Database\Seeders;

use App\Models\TrainingType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
           // TeamSeeder::class,
            TrainingTypeSeeder::class,
            RoundSeeder::class,
            ActivityStatusSeeder::class
        ]);
    }
}
