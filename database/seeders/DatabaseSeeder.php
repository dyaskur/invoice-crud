<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Item;
use App\Models\ItemType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([CountriesTableSeeder::class]);
        Company::factory(20)->create();
        ItemType::query()->insert([
                                      ['name' => 'Service'],
                                      ['name' => 'Electronic'],
                                      ['name' => 'House'],
                                      ['name' => 'Island'],
                                  ]);
        Item::factory(20)->create();
        $this->call([InvoicesTableSeeder::class]);
    }
}
