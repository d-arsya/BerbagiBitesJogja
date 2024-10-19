<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\Hero;
use App\Models\Sponsor;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            "username"=>env('ADMIN_USERNAME'),
            "password"=>Hash::make(env('ADMIN_PASSWORD')),
            "role"=>"super"
        ]);
        // Sponsor::factory(2)->create();
        // Donation::factory(1)->create();
        // Hero::factory(10)->create();
    }
}
