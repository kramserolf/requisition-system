<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       User::create([
        'name' => 'Joreim Badajos',
        'email' => 'joreim@gmail.com',
        'password' => Hash::make('12345678'),
        'is_role' => 0
       ]);

    }
}
