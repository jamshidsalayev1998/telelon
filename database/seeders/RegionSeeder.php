<?php

namespace Database\Seeders;

use App\Service\TranslateService;
use Illuminate\Database\Seeder;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = config('projectDefaultValues.regions');
        foreach ($regions as $region) {
            if (!Region::where('id', $region['id'])->exists()) {
                $newRegionData = [
                    'id' => $region['id'],
                    'name' => $region['name']['uz']
                ];
                $newRegion = Region::create($newRegionData);
                (new TranslateService())->storeTranslate($newRegion, $region['name'], 'name');
            }
        }
    }
}
