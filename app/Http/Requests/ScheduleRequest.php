<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;


class ScheduleRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'customer_id' => 'required',
        ];
    }

    public function messages()
    {

        return [
            'title.required' => 'Defina o título!',
            'customer_id.required' => 'Selecione o cliente!'
        ];

    }

    protected function failedValidation(Validator $validator)
    {

        $response = new JsonResponse([
            'errors' => $validator->errors(),
        ], 422);
    
        throw new ValidationException($validator, $response);
    }

    // protected function 


}