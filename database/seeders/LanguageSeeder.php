<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = config('projectDefaultValues.default-languages');
        foreach ($languages as $language) {
            if (!Language::where('key', $language['key'])->exists()) {
                $newLanguage = new Language();
                $newLanguage->name = $language['name'];
                $newLanguage->key = $language['key'];
                $newLanguage->save();
            }
        }
    }
}
