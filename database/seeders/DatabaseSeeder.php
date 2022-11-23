<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Account;
use App\Models\Category;
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
    //    User::create([
    //     'name' => 'Fr. Gerard Ariston P. Perez',
    //     'email' => 'frgerry@gmail.com',
    //     'password' => Hash::make('12345678'),
    //     'is_role' => 2
    //    ]);
        // Account::create([
        //     'user_id' => 3,
        //     'role_type' => 'Admin',
        //     'position' => 'College President'
        // ]); 

        Category::create([
            'title' => 'Sports'
        ]);
    }
}
