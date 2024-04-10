<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class MenuItemsController extends Controller
{


    public function items()
    {


        $permissions = Permission::all()->toArray();

        $menu = array_map(function ($per) {

            $icon = $this->setItems($per['name'])['icon'];
            $text = $this->setItems($per['name'])['text'];

            return [

                'name'        => $per['name'],
                'text'        => $text,
                'url'         => "admin/{$per['name']}",
                'icon'        => $icon,
                'label'       => 0,
                'label_color' => 'success',

            ];
        }, $permissions);

        return $menu;
    }

    public function setItems($item)
    {
        $items = [
            'products'  => ['icon' => 'fas fa-cube', 'text' => 'Produtos'],
            'schedules'  => ['icon' => 'far fa-fw fa-calendar', 'text' => 'Agenda'],
            'profiles'  => ['icon' => 'far fa-fw fa-user', 'text' => 'Perfis'],
            'store'  => ['icon' => 'fa fa-store', 'text' => 'Loja'],
            'customers'  => ['icon' => 'far fa-fw fa-envelope', 'text' => 'Clientes'],
        ];

        return $items[$item];
    }
}
