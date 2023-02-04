<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class PublicScheduleController extends Controller
{

    public function index($id, $crypt)
    {

        $customer = Customer::get()->where('mail', base64_decode($crypt));

        if ($customer) {

            // return response('Autenticado');
            
        }


        
        return view('customer/index');


    }
}