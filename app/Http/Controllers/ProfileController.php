<?php

namespace App\Http\Controllers;

use App\Http\Classes\Helpers;
use App\Http\Requests\ProfileRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $roles = Role::all();

        return response()->view('admin.profile.index', compact('roles'));
    }

    public function to_datatables()
    {

        $roles = Role::all();
        $data = array();

        $helper = new Helpers();

        foreach ($roles as $role) {

            $editButton = $helper->button_template('<i  class="fas fa-edit"></i>', 'button', [
                'class'       => 'btn btn-success edit',
                'data-id'     => $role->id,
                'data-target' => '#exampleModal',
                'data-toggle' => 'modal'
            ]);

            $deleteButton = $helper->button_template('<i  class="fas fa-trash"></i>', 'button', [
                'class'       => 'btn btn-danger delete',
                'data-id'     => $role->id,
                'data-target' => '#confirmModal',
                'data-toggle' => 'modal'
            ]);


            $data[] = [
                'description' => $role->name,
                'options' => $editButton . ' ' . $deleteButton,
            ];
        }

        $response = array(
            "aaData" => $data
        );

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProfileRequest $request)
    {
        
        $role = new Role;

        $data = $request->only(["name"]);

        if($role->create(array_merge($data, ['guard_name' => 'web']))){

            $results = ['message' => 'Perfil cadastrado com sucesso!', 'code' => 200, 'success' => true];

            return response()->json($results);
            
        }else{
            
            return response()->json(["success" => false]);

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
        return response(Role::findOrfail($id), 200)
        ->header('Content-type', 'text/json');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, $id)
    {
        Role::updateOrCreate(
            ['id' => $id],
            [
                'name'  => $request->name
            ]
        );

        return Response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);

        if ($role->delete()) {
            return Response()->json(['success' => true]);
        };
    }

}
