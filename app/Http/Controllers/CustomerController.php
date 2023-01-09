<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Exception;
use App\Http\Classes\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function index()
    {
        $customers = Customer::all();

        return view('/admin/customers')->with('customers', $customers);
    }

    public function to_datatables()
    {

        // $customers = Customer::all();
        $customers = DB::table('customers')->where('user_id', 1)->get();

        $data = array();

        foreach ($customers as $customer) {

            $editButton = '<button 
            class="btn btn-success edit-button" 
            data-target="#exampleModal"
            onclick="Fetch('.$customer->id.')"
            data-customer-id="'.$customer->id.'" 
            data-toggle="modal" 
            type="button"
            >
            <i  class="fas fa-edit"></i></button>';

            $data[] = array(
                'name' => $customer->name,
                'phone' => $customer->phone,
                'options' => $editButton
            );
        }

        $response = array(
            "aaData" => $data
        );

        return json_encode($response);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $Helpers = new Helpers();

        $customer = new Customer;
        $results = [];

        if ($request) {


            if ($Helpers->CPFisValid($request->cpf)) {

                $doc = preg_replace('/[^0-9]/m', '', $request->cpf);

                try {
                    $customer->name = $request->name;
                    $customer->cpf = $doc;
                    $customer->mail = $request->mail;
                    $customer->phone = $request->phone;
                    $customer->password = $request->password;
                    $customer->user_id = Auth::user()->id;
                    $customer->save();

                    $results = ['message' => 'Cliente cadastrado com sucesso!', 'code' => 200];

                } catch (Exception $error) {

                    $results = ['message' => 'Erro ao cadastrar cliente!', 'code' => 401];

                    // throw new Exception($error->getMessage());


                }
            } else {

                $results = ['message' => 'CPF inválido!', 'code' => 400];
            }

            return response($results, $results['code'])
                ->header('Content-Type', 'text/json');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response(Customer::findOrfail($id), 200)
        ->header('Content-type', 'text/json');
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $doc = preg_replace('/[^0-9]/m', '', $request->cpf);

        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->cpf = $doc;
        $customer->mail = $request->mail;
        $customer->phone = $request->phone;

        if($request->password){   
            $customer->password = $request->password;
        }
        
        $customer->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}