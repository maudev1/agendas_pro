<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'mauriciojr.dev@gmail.com',
            'password' => 'juniorsk8'
        ]);
    }

    public function createCompany()
    {
    
        \App\Models\Company::factory()->create([
            'name' => 'Cabelereiros Bolinhos',
        ]);


    }
}
