<?php

namespace Database\Seeders;


use App\Models\Company;
use App\Models\Invoice;
use App\Models\Item;
use Faker\Factory;
use Illuminate\Database\Seeder;

class InvoicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $seed_qty = 26;
        $faker    = Factory::create();
        for ($i = 0; $i <= $seed_qty; $i++) {
            $item_qty = rand(1, 4);
            $items    = [];
            for ($j = 0; $j < $item_qty; $j++) {
                $item    = Item::query()->inRandomOrder()->first();
                $items[] = [
                    'item_id'  => $item->id,
                    'quantity' => rand(1, 10),
                    'price'    => $item->price,
                ];
            }
            $items    = collect($items);
            $subtotal = $items->sum(function($item) {
                return $item['quantity'] * $item['price'];
            });

            $issuer    = Company::query()->inRandomOrder()->first();
            $recipient = Company::query()->inRandomOrder()->first();

            $invoiceData = [
                'subject'        => $faker->randomElement(['Hopeful', 'Enjoyable', 'Super', "Master", 'Special', 'Smart', "Intel"]).
                    " ".$faker->randomElement(['Marketing', 'Webinar', 'Exhibition', "Event", 'Vacation', "Genocide", "Omnicide"]).
                    " ".$faker->randomElement(['Campaign', 'Experiment', 'Subject', 'Project', 'Program']),
                'issued_by'      => $issuer->id,
                'issued_for'     => $recipient->id,
                'sub_total'      => $subtotal,
                'invoice_number' => str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'tax_percentage' => 15,
                'tax_amount'     => $subtotal * 0.15,
                'total_payment'  => $subtotal * 0.15 + $subtotal,
                'issue_date'     => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
                'due_date'       => $faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
                'status'         => $faker->randomElement(['draft', 'paid', 'canceled']),
            ];
            $invoice     = Invoice::query()->create($invoiceData);
            $invoice->invoiceItems()->createMany($items->toArray());
        }
    }
}
