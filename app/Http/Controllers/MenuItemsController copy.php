<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class MenuItemsController extends Controller
{

    public function items()
    {

        $permissions = Permission::with('attributes')->get()->toArray();

        $menu = array_map(function ($per) {
            return [

                'pos'         =>  $per['attributes']['position'],
                'name'        =>  $per['name'],
                'text'        =>  $per['attributes']['label'],
                'url'         =>  "admin/{$per['name']}",
                'icon'        =>  $per['attributes']['icon'],
                'label'       => 0,
                'label_color' => 'success',

            ];
        }, $permissions);

        array_multisort($menu, SORT_ASC, SORT_REGULAR);

        return $menu;
    }

}
