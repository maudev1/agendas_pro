<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

/**
 * Summary of CustomerRequest
 */
class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {

        return [

            'name.required' =>  'O :attribute é obrigatório!',
            'phone.unique' =>   'O :attribute já está cadastrado!',
            'document.unique' =>   'O :attribute já está cadastrado!',
            'email.unique' =>   'O :attribute já está cadastrado!',
            'email.required' =>   'O :attribute é obrigatório!',
            'password.required' =>   'O :attribute é obrigatória!',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'name'         =>   'required',
            'email'        =>   ['required', 'unique:users'],
            'profile'     =>    'required',
            'password'    =>    'required',
            're_password' =>    ['required', 'same:password'],
        ];

        if ($this->checkIsPhone()) {

            $rules['phone'] = 'unique:users';
        }


        if ($this->checkIsDocument()) {

            $rules['document'] = 'unique:users';
        }


        return $rules;
    }


    public function attributes()
    {
        return [
            'name'        => 'Nome',
            'phone'       => 'Telefone',
            'email'       => 'E-mail',
            'password'    => 'Senha',
            're_password' => 'Confirmação de senha',
            'profile'  => 'Perfil',
            'document' => 'Documento',

        ];
    }

    protected function failedValidation(Validator $validator)
    {

        $response = new JsonResponse([
            'errors' => $validator->errors(),
        ], 422);

        throw new ValidationException($validator, $response);
    }

    protected function checkIsPhone()
    {

        $request  = $this->request->all();

        $user = User::where("phone", $request["phone"])->where("id", "<>", $request["id"])->get()->count();

        if ($user > 0) {
            return true;
        }
    }

    protected function checkIsDocument()
    {

        $request  = $this->request->all();

        $user = User::where("document", $request["document"])->where("id", "<>", $request["id"])->get()->count();

        if ($user > 0) {
            return true;
        }
    }

    public function withValidator($validator)
    {
        $validator->sometimes('phone', 'unique:users,phone', function($input){

            return !empty($input->phone);

        });

        $validator->sometimes('document', 'unique:users,document', function($input){

            return !empty($input->phone);

        });

    }



}
