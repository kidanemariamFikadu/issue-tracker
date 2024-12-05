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
        // User::factory(10)->create();

        ApplicationSeeder::class;
        CategorySeeder::class;
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@larsha.com',
            'password' => 'Admin@123'
        ]);

        $user->syncRoles(['admin']);
    }
}
