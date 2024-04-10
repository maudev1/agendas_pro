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
class CustomerRequest extends FormRequest
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
            'phone.unique' =>   'O :attribute ja está cadastrado!',
            'document.required' => 'O :attribute é obrigatório!',
            'document.unique' =>   'O :attribute ja está cadastrado!',
            'email.unique' =>   'O :attribute ja está cadastrado!',

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
            'name'     =>  'required',
            'email'    =>  'required|unique',
            'password' =>  'required',
            'profile'  =>  'required',

        ];

        if ($this->checkIsPhone()) {

            $rules['phone'] = 'unique:customers';
        }


        if ($this->checkIsDocument()) {

            $rules['document'] = 'unique:customers';
        }

        return $rules;
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
    
}
