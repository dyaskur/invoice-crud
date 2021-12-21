<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Item;
use App\Models\ItemType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape([
        'subject'    => "string",
        'issued_by'  => "integer",
        'issued_for' => "integer",
    ])] public function definition(): array
    {
        $issuer    = Company::query()->inRandomOrder()->first();
        $recipient = Company::query()->inRandomOrder()->first();

        return [
            'subject' => $this->faker->randomElement(['Hopeful', 'Enjoyable', 'Super', "Master", 'Special', 'Smart', "Intel"]).
                " ".$this->faker->randomElement(['Marketing', 'Webinar', 'Exhibition', "Event", 'Vacation', "Genocide", "Omnicide"]).
                " ".$this->faker->randomElement(['Campaign', 'Experiment', 'Subject', 'Project', 'Program']),

            'issued_by'  => $issuer->id,
            'issued_for' => $recipient->id,
        ];
    }
}
