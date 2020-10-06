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
        $oras_plecare = \App\Models\Oras::all()->where('tara', 'Romania')->random()->id;
        // $raport_traseu_initial = \App\Models\Oras::find($oras_plecare)->id;

        return [
            'nume' => $this->faker->name,
            'telefon' => $this->faker->phoneNumber,
            'nr_adulti' => $this->faker->numberBetween(1 ,4),
            'oras_plecare' => $oras_plecare,
            'oras_sosire' => \App\Models\Oras::all()->where('tara', 'Franta')->random()->id,
            'raport_traseu_initial' => \App\Models\Oras::find($oras_plecare)->traseu,
            'data_cursa' => '2020-10-28'
        ];
    }
}
