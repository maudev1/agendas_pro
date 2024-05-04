<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerAuthController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function register(CustomerRequest $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $cpf = preg_replace('/[^0-9]/m', '', $request->cpf);

        $customer = Customer::create([
            "name"     => $request->name,
            "cpf"      => $cpf,
            "email"     => $request->email,
            "user_id"  => "0",
            "phone"    => $request->phone,
            "password" => Hash::make($request->password),

        ]);


        $results = [];

        if ($customer) {
            $token = $customer->createToken('token-name', ['server:update'])->plainTextToken;

            $results['success'] = true;
            $results['data'] = [
                'customer_info' => $customer,
                'token' => $token
            ];

            return response()->json($results);
        }
    }

    public function login(Request $request)
    {

        $user = Customer::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        return response()->json([
            'access_token' => $token,
        ]);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
    
        return response()->json([
          "message"=>"logged out"
        ]);
    }
}
