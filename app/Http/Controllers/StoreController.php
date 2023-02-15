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

    public function update(Request $request, $id){
        $store = Store::find($id);

        // return response($request->nane);

        if($store){

            $store->name = $request->name;
            $store->user_id = $id;
            $store->slogan = $request->slogan;
            $store->office_hour = $request->office_hour;
            $store->work_days = $request->work_days;
            $store->logo = !empty($request->logo) ? $request->logo :  'NONE';
            $store->save();
        }

        return redirect('/admin/store');

    }


    public function store(Request $request){

        $id = Auth::user()->id;
     
        if($request){

            $store = new Store();

            // return response($request->logo);

            $store->name = $request->name;
            $store->user_id = $id;
            $store->slogan = $request->slogan;
            $store->office_hour = $request->office_hour;
            $store->work_days = $request->work_days;
            $store->logo = !empty($request->logo) ? $request->logo :  'NONE';

            $store->save();


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
