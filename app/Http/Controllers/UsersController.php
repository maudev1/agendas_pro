<?php


// ! TERMINAR ESSA CARALHA

namespace App\Http\Controllers;

use App\Http\Classes\Helpers;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $roles = Role::all();

        $fields = [
            ['required' => true, 'label' => 'Nome', 'field' => 'name'],
            ['label' => 'CPF', 'field' => 'document'],
            ['label' => 'Telefone', 'field' => 'phone'],
            ['required' => true, 'label' => 'E-mail', 'field' => 'email'],
            ['required' => true, 'label' => 'Perfil', 'field' => 'profile'],
            ['required' => true, 'label' => 'Senha', 'field' => 'password'],
            ['required' => true, 'label' => 'Confirmação de Senha', 'field' => 're_password'],
        ];

        return view('admin.user.index', compact('roles', 'fields'));
    }

    public function to_datatables()
    {
        $users = User::all();

        $data = array();

        $helper = new Helpers();

        foreach ($users as $user) {

            $editButton = $helper->button_template('<i  class="fas fa-edit"></i>', 'button', [
                'class'       => 'btn btn-success edit',
                'data-id'     => $user->id,
                'data-target' => '#exampleModal',
                'data-toggle' => 'modal'
            ]);

            $deleteButton = $helper->button_template('<i  class="fas fa-trash"></i>', 'button', [
                'class'       => 'btn btn-danger delete',
                'data-id'     => $user->id,
                'data-target' => '#confirmModal',
                'data-toggle' => 'modal'
            ]);


            $data[] = [
                'name'      => $user->name,
                'email'     => $user->email,
                'phone'     => $user->phone,
                'profile'   => $user->profile,
                'options'   => $editButton . ' ' . $deleteButton,
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
    public function store(UserRequest $request)
    {

        $user = new User;

        $data = $request->only(["name", "document", "email", "password", "phone"]);
       
        if ($user->create($data)->syncRoles($request->profile)) {
            
            $results = ['message' => 'Usuário cadastrado com sucesso!', 'code' => 200, 'success' => true];

            return response()->json($results);

        } else {

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
        $user  = User::findOrfail($id);
        $roles = $user->getRoleNames();

        return response(['user' => User::findOrfail($id), 'roles' => $roles], 200)
            ->header('Content-type', 'text/json');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {

        $data = $request->only(["name", "document", "phone", "password", "re_password"]);

        User::updateOrCreate(
            ['id' => $id],
            $data
        )->syncRoles($request->profile);

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
        $user = User::find($id);
        
        if($user->delete()){

            return response()->json(['success' => true]);

        }
    }
}
