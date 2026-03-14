<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed admin user (skip if already exists)
        if (!Admin::where('email', 'admin@mail.com')->exists()) {
            Admin::create([
                'name'     => 'Admin',
                'email'    => 'admin@mail.com',
                'password' => bcrypt('12345678'),
            ]);
        }

        $this->call(BusinessSeeder::class);
    }
}
