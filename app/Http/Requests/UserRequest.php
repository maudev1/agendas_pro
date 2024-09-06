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

        if ($this->isMethod('post')) {


            $rules =  [
                'name'         =>   'required',
                'email'        =>   ['required', 'unique:users'],
                'profile'     =>    'required',
                'password'    =>    'required',
                're_password' =>    ['required', 'same:password'],
            ];



        }

        if($this->isMethod('put')){

            $rules =  [
                'name'         =>    'required',
                'profile'      =>    'required',
            ];



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


    public function withValidator($validator)
    {

        if($this->isMethod('post')){

            $validator->sometimes('phone', 'unique:users,phone', function ($input) {
                
                return !empty($input->phone);

            });
            
            $validator->sometimes('document', 'unique:users,document', function ($input) {
                
                return !empty($input->phone);

            });
            
        }


        if($this->isMethod('put')){

            $validator->sometimes('password', 'required', function ($input) {

                return !empty($input->password);
            });

            $validator->sometimes('re_password', 'required', function ($input) {

                return !empty($input->password);
            });

            $validator->sometimes('password', 'required', function ($input) {

                return !empty($input->re_password);
            });

            $validator->sometimes('re_password', 'required', function ($input) {

                return !empty($input->password);
            });


        }
    }
}
