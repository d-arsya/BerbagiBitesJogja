<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hero>
 */
class HeroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'telepon' => fake()->phoneNumber(),
            'fakultas' => fake()->randomElement([
                "Biologi", "Ekonomi Bisnis", "Filsafat", "Fisipol", "Geografi", 
                "Hukum", "Ilmu Budaya", "Kedokteran", "Kedokteran Gigi", 
                "Kedokteran Hewan", "Kehutanan", "MIPA", "Pascasarjana", 
                "Pertanian", "Peternakan", "Psikologi", "Teknologi Pertanian", 
                "Vokasi"
            ]
              ),
            'status'=>fake()->randomElement(["sudah","belum"]),
            'donation'=>fake()->numberBetween(1),
            'kode'=>fake()->numberBetween(100000,999999)
        ];
    }
}
