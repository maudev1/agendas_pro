<?php

namespace Database\Seeders;

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
      
        return User::create([
            'name' => 'administrador',
            'email' => 'mauriciojr.dev@gmail.com',
            'document' => '38818602829',
            'phone' => '11996502162',
            'password' => Hash::make('juniorsk8'),
        ]);
    }
}
