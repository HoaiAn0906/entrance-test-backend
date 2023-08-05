<?php

namespace Database\Seeders;

// use IllArtisanuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $email = 'admin@yopmail.com';

        if (!User::query()->where('email', $email)->exists()) {
            User::factory()
                ->create([
                    'name' => 'Admin',
                    'email' => $email,
                    'email_verified_at' => now(),
                    'password' => bcrypt('123123'),
                ]);
        }

        Artisan::call('passport:install');
    }
}
