<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::count()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@studio.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
            ]);
            $this->command->info('Admin user created.');
        }

        $this->call([
            MaterialSeeder::class,
            TaskSeeder::class,
            BudgetSeeder::class,
        ]);
    }
}
