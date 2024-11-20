<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\Faculty;
use App\Models\Hero;
use App\Models\Sponsor;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    private $faculties = [
        "Biologi", "Ekonomi Bisnis", "Filsafat", "Fisipol", "Geografi", 
        "Hukum", "Ilmu Budaya", "Kedokteran", "Kedokteran Gigi", 
        "Kedokteran Hewan", "Kehutanan", "MIPA", "Pascasarjana", 
        "Pertanian", "Peternakan", "Psikologi", "Teknologi Pertanian", 
        "Vokasi","Lainnya","Kontributor"
    ];
    public function run(): void
    {
        User::create([
            "username"=>env('STAFF_USERNAME'),
            "password"=>Hash::make(env('STAFF_PASSWORD')),
            "role"=>"staff"
        ]);
        User::create([
            "username"=>env('CORE_USERNAME'),
            "password"=>Hash::make(env('CORE_PASSWORD')),
            "role"=>"core"
        ]);
        foreach ($this->faculties as $item) {
            Faculty::create(["name"=>$item]);
        }

        // Sponsor::factory(2)->create();
        // Donation::factory(1)->create();
        // Hero::factory(10)->create();
    }
}
