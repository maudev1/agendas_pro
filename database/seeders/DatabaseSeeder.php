<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use App\Models\Profile;
use Spatie\Permission\Models\Permission;
use App\Models\Store;
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


        // ? Store Creation
        
        $this->storeCreate();
        
        // ? SuperAdmin Creation
        
        $this->superAdminCreate();


    }

    public function storeCreate(){

        $user =  new Store();
        $user->insert([
            'name' => 'Agendaspro BarberShop',
            'slogan' => 'Agende qualquer coisa aqui',
            'office_hour_start' => '08:00:00',
            'office_hour_end'   => '20:00:00',
            'logo' => '/public/img/logo.jpeg',
            'user_id' => '1'
        ]);

    }

    public function superAdminCreate(){

      
        $user =  new User();
        $user->insert([
            'name' => 'admin',
            'email' => 'admin@agendaspro.com',
            'document' => '3333333333',
            'phone' => '11996502162',
            'store' => '1',
            'password' => Hash::make('juniorsk8')
        ]);

        // Create Permissions

        $permissions = new PermissionSeeder();
        $permissions->run();

        // Create Rules

        $roles = new RoleSeeder();
        $roles->run();

        // Add Rule to User admin

        $user->assignRole('super');



    }

}
