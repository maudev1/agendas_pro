<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        $user =  new User();
        
        $user->insert([
            'name' => 'admin',
            'email' => 'admin@agendaspro.com',
            'document' => '3333333333',
            'phone' => '11996502162',
            'password' => Hash::make('juniorsk8')
        ]);

        // Create Permissions

        $permissions = new PermissionSeeder();
        $permissions->run();

        // Create Rules

        $roles = new RoleSeeder();
        $roles->run();

        // Add Rule to User admin

        $user->assignRole('admin');

    }

}
