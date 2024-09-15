<?php

namespace Database\Seeders;

use App\Models\PermissionAttribute;
use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Permission;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $permissions = [
            ['name' => 'schedules', 'label'  => 'agenda', 'icon' => 'far fa-fw fa-calendar', 'position' => '0'],
            ['name' => 'customers', 'label' => 'clientes', 'icon' => 'far fa-fw fa-envelope', 'position' => '1'],
            ['name' => 'products', 'label'  => 'produtos', 'icon' => 'fas fa-cube', 'position' => '2'],
            ['name' => 'services', 'label'  => 'serviços', 'icon' => 'fas fa-cube', 'position' => '3'],
            ['name' => 'users', 'label' => 'usuários', 'icon' => 'far fa-fw fa-user', 'position' => '4'],
            ['name' => 'profiles', 'label' => 'perfis', 'icon' => 'far fa-fw fa-user', 'position' => '5'],
            ['name' => 'store', 'label' => 'loja', 'icon' => 'fas fa-store', 'position' => '6']
        ];

        foreach ($permissions as $permission) {

            $permissionCreated = Permission::create(['name' => $permission['name'], 'guard_name' => 'web']);

            // PermissionAttribute::create([
            //     'permission_id' => $permissionCreated->id,
            //     'label'         => $permission['label'],
            //     'icon'          => $permission['icon'],
            //     'position'      => $permission['position']
            // ]);

            $permissionCreated->attributes()->create([
                'label'         => $permission['label'],
                'icon'          => $permission['icon'],
                'position'      => $permission['position']
            ]);
        }
    }
}
