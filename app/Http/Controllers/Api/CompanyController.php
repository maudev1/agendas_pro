<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Models\Company::all(['id', 'name']);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return false;
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $company  =  Models\Company::create(["name" => $request->name]);

        if(isset($company->id)){
            
            return response([
                'success' => 'true', 
                'message' => 'Empresa criada com sucesso!'
                ]);

        }

        return response([
            'success' => 'false', 
            'message' => 'Erro ao criar empresa!'
            ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Models\Company::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return false;
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
        $company  =  Models\Company::find($id);
        $company->name = $request->name;

        if($company->save()){

            return response()->json([
                'success' => 'true', 
                'message' => 'Empresa atualizada com sucesso!'
                ]);
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company  =  Models\Company::find($id);
        
        if($company->delete()){

            return response()->json([
                'success' => 'true', 
                'message' => 'Empresa excluida com sucesso!'
                ]);
        }
        
    }
}
