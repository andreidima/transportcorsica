<?php

namespace Database\Factories;

use App\Models\Pasager;
use Illuminate\Database\Eloquent\Factories\Factory;

class PasagerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pasager::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nume' => $this->faker->name,
            'buletin' => $this->faker->bothify('??######'),
            'data_nastere' => $this->faker->date($format = 'Y-m-d', $startDate = '-30 years', $max = '-20 years'),
            'localitate_nastere' => $this->faker->city,
            'localitate_domiciliu' => $this->faker->city
        ];
    }
}
