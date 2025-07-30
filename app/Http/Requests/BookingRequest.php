<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
}
