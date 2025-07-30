<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ApiResponse;

class ServiceRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules() {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ApiResponse::error(
                $validator->errors()->first(),
                422,
                ['errors' => $validator->errors()]
            )
        );
    }
}
