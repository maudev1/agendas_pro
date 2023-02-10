<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function index()
    {

        $id = Auth::user()->id;

        $store = Store::where('user_id',$id)->first();

        return view('admin/store',['store' => $store]);
        

    }


    public function store(Request $request){

        $id = Auth::user()->id;
     
        if($request){

            DB::table('stores')
                ->updateOrInsert(
                    ['logo' => 'teste', 'name' => $request->name],
                    ['user_id' => $id]);

            // try{

            //     $store->name  = $request->name;
            //     $store->user_id = Auth::user()->id;
            //     $store->logo = 'logo_url';
            //     $store->create();

            
            // }catch(Exception $exception){

            // }

            return redirect('/admin/store');

        }

    }


}
