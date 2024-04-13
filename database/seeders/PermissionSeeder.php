<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'products'  , 'guard_name' => 'web']);
        Permission::create(['name' => 'schedules' , 'guard_name' => 'web']);
        Permission::create(['name' => 'profiles'  , 'guard_name' => 'web']);
        Permission::create(['name' => 'store'     , 'guard_name' => 'web']);
        Permission::create(['name' => 'customers' , 'guard_name' => 'web']);
    }
}
