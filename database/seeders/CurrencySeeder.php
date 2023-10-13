<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = config('projectDefaultValues.currencies');
        foreach ($currencies as $currency) {
            if (!Currency::where('key', $currency['key'])->exists())
                Currency::create([
                    $currency
                ]);
        }
    }
}
