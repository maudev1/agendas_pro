<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
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

        return view('/admin/customers', compact('customers'));
    }

    public function to_datatables()
    {

        $customers = DB::table('customers')->where('user_id', 1)->get();
        $data = array();

        $helper = new Helpers();

        foreach ($customers as $customer) {

            $editButton = $helper->button_template('<i  class="fas fa-edit"></i>','button',[
                'class' => 'btn btn-success',
                'data-target' => '#exampleModal',
                'onclick' => 'Fetch("'.$customer->id.'")',
                'data-toggle'=>"modal" 
            ]);

            $deleteButton = $helper->button_template('<i  class="fas fa-trash"></i>','button',[
                'class' => 'btn btn-danger',
                'data-target' => '#confirmModal',
                'onclick' => 'Delete("'.$customer->id.'")',
                'data-toggle'=>"modal" 
            ]);


            $data[] = array(
                'name' => $customer->name,
                'phone' => $customer->phone,
                'options' => $editButton.' '.$deleteButton,
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
     */
    public function store(CustomerRequest $request)
    {

        $Helpers = new Helpers();
        $customer = new Customer;
    
        $doc = preg_replace('/[^0-9]/m', '', $request->cpf);

        $customer->name = $request->name;
        $customer->cpf = $doc;
        $customer->mail = $request->mail;
        $customer->phone = $request->phone;
        $customer->password = $request->password;
        $customer->user_id = Auth::user()->id;
        $customer->save();

        $results = ['message' => 'Cliente cadastrado com sucesso!', 'code' => 200];

        return response()->json($results);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * 
     */
    public function show()
    {

        $id = Auth::user()->id;

        $customers = Customer::where('user_id', $id)->get();

        return response()->json($customers);

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
     */
    public function update(Request $request, $id)
    {
        $doc = preg_replace('/[^0-9]/m', '', $request->cpf);

        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->cpf = $doc;
        $customer->mail = $request->mail;
        $customer->phone = $request->phone;

        if ($request->password) {
            $customer->password = $request->password;
        }

        $customer->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        
        if($customer->delete()){
            return Response()->json(['success' => true]);

        };

    }



}