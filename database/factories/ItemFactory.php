<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\ItemType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $item_type = ItemType::query()->inRandomOrder()->first();

        return [
            'name'         => $this->faker->randomElement(['Nganu', 'Yaskur', 'Super', "Master", 'Rohaya', 'Smart', "Intel"]).
                ' '.$this->faker->lastName()."'s ".(string)$item_type->name,
            'item_type_id' => $item_type->id,
            'price'  => rand(1,250),
        ];
    }
}
