<?php

namespace App\Http\Requests;

//use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class FlightSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "occupants" => 'required|int',
            "departure_airport" => 'required|string|size:3',
            "arrival_airport" => 'required|string|size:3',
            "check_in" => 'required|date',
            'check_out' => 'required|date',
            'type' => 'required|in:economic,firstclass'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'The :attribute field in required.',
            'size' => 'The :attribute must be exactly :size.'
        ];
    }

}
