<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models;

class UserController extends Controller
{

    /**
     * Update User
     * @param Request $request
     * @return User 
     */
    public function update($id, Request $request){

        try{
            $user = User::find($id);
            $user->update($request->all());

        }catch(\Throwable $th){

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

}
