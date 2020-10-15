<?php

namespace Database\Factories;

use App\Models\ClientNeserios;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientNeseriosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientNeserios::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nume' => $this->faker->name,
            'telefon' => $this->faker->phoneNumber,
            'observatii' => $this->faker->boolean($chanceOfGettingTrue = 20) ? null : $this->faker->text($maxNbChars = 50)
        ];
    }
}
