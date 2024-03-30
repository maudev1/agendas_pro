<?php

namespace App\Http\Controllers;

use App\Http\Classes\Helpers;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
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

        $profiles = Profile::all();

        return response()->view('admin.profile.index', compact('profiles'));
    }

    public function to_datatables()
    {

        $profiles = Profile::all();
        $data = array();

        $helper = new Helpers();

        foreach ($profiles as $profile) {

            $editButton = $helper->button_template('<i  class="fas fa-edit"></i>', 'button', [
                'class'       => 'btn btn-success edit',
                'data-id'     => $profile->id,
                'data-target' => '#exampleModal',
                'data-toggle' => 'modal'
            ]);

            $deleteButton = $helper->button_template('<i  class="fas fa-trash"></i>', 'button', [
                'class'       => 'btn btn-danger delete',
                'data-id'     => $profile->id,
                'data-target' => '#confirmModal',
                'data-toggle' => 'modal'
            ]);


            $data[] = [
                'description' => $profile->description,
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
        
        $profile = new Profile;

        $data = $request->only(["description"]);

        if($profile->create($data)){

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
        return response(Profile::findOrfail($id), 200)
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
        Profile::updateOrCreate(
            ['id' => $id],
            [
                'description'  => $request->description
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
        $profile = Profile::find($id);

        if ($profile->delete()) {
            return Response()->json(['success' => true]);
        };
    }
}
