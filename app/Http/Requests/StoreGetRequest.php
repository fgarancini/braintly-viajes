<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class StoreGetRequest extends Request
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
            "occupants" => 'required|numeric',
            "departure_airport" => 'required|string|size:3',
            "arrival_airport" => 'required|string|size:3',
            "check_in" => 'required|date',
            'check_out' => 'required|date',
            'type' => 'required'
        ];
    }
}
