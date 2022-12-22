<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = config('projectDefaultValues.permissions');
        foreach ($permissions as $permission) {
            if (!Permission::where('name' , $permission)->exists()) Permission::create(['name' => $permission]);
        }
    }
}
