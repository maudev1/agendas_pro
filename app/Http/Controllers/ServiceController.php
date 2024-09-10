<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use App\Http\Classes\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use NumberFormatter;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function index()
    {
        $services = Service::all();

        return view('admin.service.index', compact('services'));
    }

    public function to_datatables()
    {
        $services = Service::all();
        $data = array();

        $helper = new Helpers();
        $moneyFormat = numfmt_create("pt_BR", NumberFormatter::CURRENCY);

        foreach ($services as $service) {

            $editButton = $helper->button_template('<i  class="fas fa-edit"></i>', 'button', [
                'class'       => 'btn btn-success edit',
                'data-id'     => $service->id,
                'data-target' => '#exampleModal',
                'data-toggle' => 'modal'
            ]);

            $deleteButton = $helper->button_template('<i  class="fas fa-trash"></i>', 'button', [
                'class'       => 'btn btn-danger delete',
                'data-id'     => $service->id,
                'data-target' => '#confirmModal',
                'data-toggle' => 'modal'
            ]);


            $data[] = [
                'description' => $service->description,
                'discount'   =>  $service->discount,
                'price'   => numfmt_format_currency($moneyFormat, $service->price, "BRL"),
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
    public function store(ServiceRequest $request)
    {

        $Helpers = new Helpers();
        $services = new Service;

        $data = $request->only(["description", "price", "discount"]);

        if ($services->create($data)) {

            $results = ['message' => 'Cliente cadastrado com sucesso!', 'code' => 200, 'success' => true];

            return response()->json($results);
        } else {

            return response()->json(["success" => false]);
        }
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

        return response(Service::findOrfail($id), 200)
            ->header('Content-type', 'text/json');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(ServiceRequest $request, $id)
    {

        Service::updateOrCreate(
            ['id' => $id],
            [
                'description'  => $request->description,
                'price' => $request->price,
                'discount' => $request->discount,
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
        $services = Service::find($id);

        if ($services->delete()) {
            return Response()->json(['success' => true]);
        };
    }


}
