<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class MenuItemsController extends Controller
{


    public function items()
    {


        // $permissions = Permission::whereNotIn("name",['users','profiles'])->get()->toArray();
        $permissions = Permission::get()->toArray();

        $menu = array_map(function ($per) {

            $icon = $this->setItems($per['name'])['icon'];
            $text = $this->setItems($per['name'])['text'];
            $pos  = $this->setItems($per['name'])['pos'];

            return [

                'pos'         =>  $pos,
                'name'        => $per['name'],
                'text'        => $text,
                'url'         => "admin/{$per['name']}",
                'icon'        => $icon,
                'label'       => 0,
                'label_color' => 'success',

            ];
        }, $permissions);

        array_multisort($menu, SORT_ASC, SORT_REGULAR);

        return $menu;
    }

    public function setItems($item)
    {
        $items = [
            'schedules'  => ['pos' => '1','icon' => 'far fa-fw fa-calendar', 'text' => 'Agenda'],
            'customers'  => ['pos' => '2','icon' => 'far fa-fw fa-envelope', 'text' => 'Clientes'],
            'products'   => ['pos' => '3','icon' => 'fas fa-cube', 'text' => 'Produtos'],
            'users'      => ['pos' => '4','icon' => 'far fa-fw fa-user', 'text' => 'Usuários'],
            'profiles'   => ['pos' => '5','icon' => 'far fa-fw fa-user', 'text' => 'Perfis'],
            'store'      => ['pos' => '6','icon' => 'fa fa-store', 'text' => 'Loja'],
        ];

        return $items[$item];
    }
}
