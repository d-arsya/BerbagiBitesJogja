<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kuota = fake()->numberBetween(10,100);
        return [
            'sponsor'=>fake()->numberBetween(1,2),
            'kuota'=>$kuota,
            'sisa'=>$kuota,
            'pengambilan'=>fake()->dateTimeBetween('now','+30 days'),
            'jam'=> fake()->numberBetween(11,15),
            'lokasi'=>fake()->address(),
            'maps'=>"masp.com",
            'status'=>fake()->randomElement(["aktif","selesai"])
        ];
    }
}
