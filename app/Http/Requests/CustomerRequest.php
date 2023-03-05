<?php

namespace App\Http\Requests;

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

    public function messages(){


        return [

            'name.required' => 'O :attribute é obrigatório!',
            'phone.unique' =>  'O :attribute ja está cadastrado!', 
            'phone.required' => 'O :attribute é obrigatório!' 

        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'name' =>  'required',
            'phone' => 'required|unique:customers'
            
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        $response = new JsonResponse([
            'errors' => $validator->errors(),
        ], 422);
    
        throw new ValidationException($validator, $response);
    }



}
