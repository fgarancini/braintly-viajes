<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGetRequest;
use Illuminate\Http\Request;
use App\Services\FlightService;
use Illuminate\Support\Facades\Validator;

class FlightController extends Controller
{
    protected FlightService $flight_service;

    public function __construct(FlightService $service)
    {
        $this->flight_service = $service;
    }

    public function search(Request $request)
    {
        $flight_req = $request->validate([
            "occupants" => 'required|numeric',
            "departure_airport" => 'required|string|size:3',
            "arrival_airport" => 'required|string|size:3',
            "check_in" => 'required|date',
            'check_out' => 'required|date',
            'type' => 'required'
        ]);

        return response()->json([
            'data' => $request->all()
        ]);
    }

}
