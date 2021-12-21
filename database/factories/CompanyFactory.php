<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'address_1' => $this->faker->address(),
            'address_2' => $this->faker->city()." ".$this->faker->citySuffix()." ".$this->faker->safeColorName(),
            'country_id' => Country::query()->inRandomOrder()->first()->id,
        ];
    }

}
