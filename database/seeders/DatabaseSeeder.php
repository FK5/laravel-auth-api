<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
        \App\Models\User::create([
            'name' => 'ADMIN',
            'usertype' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123123'),
        ]);
        \App\Models\User::create([
            'name' => 'Brad',
            'email' => 'brad@gmail.com',
            'password' => bcrypt('123123'),
        ]);
        \App\Models\User::factory(50)->create();
    }
    
}
