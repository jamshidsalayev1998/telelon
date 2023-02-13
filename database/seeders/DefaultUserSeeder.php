<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = config('projectDefaultValues.users');
        foreach ($users as $user) {
            if (!User::where('name', $user['name'])->exists()) {
                $newUser = User::create(['name' => $user['name'], 'password' => Hash::make('1111'), 'login' => $user['login']]);
                $newUser->assignRole($user['roles']);
            }
        }
    }
}
