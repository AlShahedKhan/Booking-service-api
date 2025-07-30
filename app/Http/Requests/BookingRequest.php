<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ApiResponse;

class BookingRequest extends FormRequest
{
    public function authorize() { return true; }
    public function rules() {
        return [
            'service_id' => 'required|exists:services,id',
            'booking_date' => [
                'required',
                'date',
                'after_or_equal:today', // Prevent past dates
            ],
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
