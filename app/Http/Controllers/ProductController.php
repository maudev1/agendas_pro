<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Http\Classes\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use NumberFormatter;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function index()
    {
        $products = Product::all();

        return view('admin.product.index', compact('products'));
    }

    public function to_datatables()
    {
        $products = Product::all();
        $data = array();

        $helper = new Helpers();
        $moneyFormat = numfmt_create("pt_BR", NumberFormatter::CURRENCY);

        foreach ($products as $product) {

            $editButton = $helper->button_template('<i  class="fas fa-edit"></i>', 'button', [
                'class'       => 'btn btn-success edit',
                'data-id'     => $product->id,
                'data-target' => '#exampleModal',
                'data-toggle' => 'modal'
            ]);

            $deleteButton = $helper->button_template('<i  class="fas fa-trash"></i>', 'button', [
                'class'       => 'btn btn-danger delete',
                'data-id'     => $product->id,
                'data-target' => '#confirmModal',
                'data-toggle' => 'modal'
            ]);


            $data[] = [
                'description' => $product->description,
                'discount'   =>  $product->discount,
                'price'   => numfmt_format_currency($moneyFormat,$product->price, "BRL"),
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
    public function store(ProductRequest $request)
    {

        $Helpers = new Helpers();
        $products = new Product;

        $data = $request->only(["description", "price", "discount"]);

        if($products->create($data)){

            $results = ['message' => 'Cliente cadastrado com sucesso!', 'code' => 200, 'success' => true];

            return response()->json($results);
            
        }else{
            
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

        return response(Product::findOrfail($id), 200)
            ->header('Content-type', 'text/json');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(ProductRequest $request, $id)
    {

        Product::updateOrCreate(
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
        $products = Product::find($id);

        if ($products->delete()) {
            return Response()->json(['success' => true]);
        };
    }
}
