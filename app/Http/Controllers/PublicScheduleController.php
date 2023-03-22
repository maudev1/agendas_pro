<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;

class PublicScheduleController extends Controller
{

    public function index($id)
    {
        $user_id = base64_decode($id);
        $user = User::get()->where('id', $user_id);
        
        if ($user) {

            $store = Store::where('user_id', $user_id)->first();
            return view('customer/index')->with('store', $store);
            
        }


        


    }
}