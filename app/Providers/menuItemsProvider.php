<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\MenuItemsController;
use Illuminate\Auth\Events\Authenticated;

class menuItemsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        
        $this->app['events']->listen(Authenticated::class, function($event){
            
            $menu = new MenuItemsController();

            $user = $event->user;

            $role = $user->roles->first();
            
            if(!$role){
                $user->assignRole('super');
            }

            $userPermissions = $role->permissions->pluck('name')->toArray();

            $userMenu = array_map(function($permission) use ($userPermissions){
                
                 if(in_array($permission['name'], $userPermissions)){
                    return $permission;
                 }

            }, $menu->items());

            
        
            Config::set("adminlte.menu", $userMenu );



        });

    }
}
