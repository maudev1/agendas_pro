<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PublicScheduleController extends Controller
{

    public function index($id)
    {

        
        $user = User::get()->where('id', base64_decode($id));
        
        if ($user) {
            
            // return response('Autenticado');
            // return response($id);
            return view('customer/index');
            
        }


        


    }
}