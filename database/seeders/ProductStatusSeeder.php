<?php

namespace Database\Seeders;

use App\Models\ProductStatus;
use Illuminate\Database\Seeder;

class ProductStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = config('projectDefaultValues.product_statuses');
        foreach ($statuses as $status) {
            if (!ProductStatus::where('id', $status['id'])->exists())
                ProductStatus::create($status);
        }
    }
}
