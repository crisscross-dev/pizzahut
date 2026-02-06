<?php

namespace Database\Seeders;

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
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@pizzahut.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@pizzahut.com',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]
        );

        // Seed pizzas
        $this->call([
            PizzaSeeder::class,
        ]);
    }
}
