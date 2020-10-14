<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClientNeseriosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return [
            'nume' => $this->faker->name,
            'telefon' => $this->faker->phoneNumber,
            'observatii' => $this->faker->boolean($chanceOfGettingTrue = 50) ? null : $this->faker->text($maxNbChars = 50)
        ];
    }
}
