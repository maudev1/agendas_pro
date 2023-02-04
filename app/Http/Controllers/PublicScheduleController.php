<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Hashing\BcryptHasher;


class PublicScheduleController extends Controller
{
    
    public function index($id, $key){


        $bcrypt = new BcryptHasher();

        if($bcrypt->check('mauriciojr.dev@gmail.com', $key)){

            
            // return view('customer/index');
            return response('Autenticado');
            
        }
        
        

    }
}
