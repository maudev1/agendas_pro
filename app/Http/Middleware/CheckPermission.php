<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $name)
    {

        $permission = Permission::where("name",$name)->first();


        
        if($permission){
            
            $user = Auth::user();
            
            $role = $user->roles->first();

            $userPermissions = $role->permissions->pluck('name')->toArray();
            
            if(in_array($permission->name, $userPermissions)){

                return $next($request);

            }

        }

        return redirect()->back();
    }
}
