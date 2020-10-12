<?php

namespace Database\Factories;

use App\Models\Rezervare;
use Illuminate\Database\Eloquent\Factories\Factory;

class RezervareFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rezervare::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $oras_plecare = \App\Models\Oras::all()->where('tara', 'Romania')->random()->id;
        // $oras_sosire = \App\Models\Oras::all()->where('tara', 'Corsica')->random()->id;
        $oras_plecare = \App\Models\Oras::all()->where('tara', 'Corsica')->random()->id;
        $oras_sosire = \App\Models\Oras::all()->where('tara', 'Romania')->random()->id;
        $nr_adulti = $this->faker->numberBetween(1 ,4);

        return [
            'nume' => $this->faker->name,
            'telefon' => $this->faker->phoneNumber,
            'nr_adulti' => $nr_adulti,
            'oras_plecare' => $oras_plecare,
            'oras_sosire' => $oras_sosire,
            'pret_total' => $nr_adulti * 120,
            'lista_plecare' => \App\Models\Oras::find($oras_plecare)->traseu,
            'lista_sosire' => \App\Models\Oras::find($oras_sosire)->traseu,
            'data_cursa' => '2020-10-31',
            'observatii' => $this->faker->boolean($chanceOfGettingTrue = 80) ? null : $this->faker->text($maxNbChars = 500)
        ];
    }
}
