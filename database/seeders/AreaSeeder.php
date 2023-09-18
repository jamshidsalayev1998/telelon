<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Service\TranslateService;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = config('projectDefaultValues.areas');
        foreach ($areas as $area) {
            if (!Area::query()->where('id', $area['id'])->exists()) {
                $newAreaData = [
                    'id' => $area['id'],
                    'name' => $area['name']['uz'],
                    'region_id' => $area['region_id'],
                ];
                $newArea = Area::query()->create($newAreaData);
                (new TranslateService())->storeTranslate($newArea, $area['name'], 'name');
            }
        }
    }
}
