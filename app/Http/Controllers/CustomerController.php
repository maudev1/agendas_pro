<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Http\Classes\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

        return view('admin.customer.index', compact('customers'));
    }

    public function to_datatables()
    {
        $customers = Customer::where('user_id', 1)->get();
        $data = array();

        $helper = new Helpers();

        foreach ($customers as $customer) {

            $editButton = $helper->button_template('<i  class="fas fa-edit"></i>', 'button', [
                'class'       => 'btn btn-success edit',
                'data-id'     => $customer->id,
                'data-target' => '#exampleModal',
                'data-toggle' => 'modal'
            ]);

            $deleteButton = $helper->button_template('<i  class="fas fa-trash"></i>', 'button', [
                'class'       => 'btn btn-danger delete',
                'data-id'     => $customer->id,
                'data-target' => '#confirmModal',
                'data-toggle' => 'modal'
            ]);


            $data[] = [
                'name'    => $customer->name,
                'phone'   => $customer->phone,
                'options' => $editButton . ' ' . $deleteButton,
            ];
        }

        $response = array(
            "aaData" => $data
        );

        return response()->json($response);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(CustomerRequest $request)
    {

        $customer = new Customer;

        $doc = preg_replace('/[^0-9]/m', '', $request->cpf);

        $customer->name = $request->name;
        $customer->cpf = $doc;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->password = Hash::make($request->password);
        $customer->user_id = Auth::user()->id;
        $customer->save();

        $results = ['message' => 'Cliente cadastrado com sucesso!', 'code' => 200, 'success' => true];

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
        return false;
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
    public function update(CustomerRequest $request, $id)
    {

        $doc = preg_replace('/[^0-9]/m', '', $request->cpf);

        Customer::updateOrCreate(
            ['id' => $id],
            [
                'name'  => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => $request->password,
                'cpf' => $doc,
            ]
        );

        return Response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);

        if ($customer->delete()) {
            return Response()->json(['success' => true]);
        };
    }
}
