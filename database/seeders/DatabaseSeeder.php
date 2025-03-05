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
        // User::factory(10)->create(); // example

        // Example (specific user)
        // User::factory()->create([
        //     'first_name' => 'John',
        //     'last_name' => 'Doe',
        //     'email' => 'test@example.com',
        // ]);

        // these are from mine
        User::factory(98)->create(); // 98 regular verified users
        User::factory()->unverified()->create(); // 1 unverified user

        User::factory()->admin()->create([
            'first_name' => 'Jonas',
            'last_name' => 'Bacuño',
            'email' => 'admin@orpawnage.com'
        ]);  // 1 admin

        $this->call(JobSeeder::class); // seeder that creates job_listings
    }
}
