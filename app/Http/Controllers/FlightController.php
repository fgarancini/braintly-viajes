<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FlightConsultService;

class FlightController extends Controller
{
    protected FlightConsultService $consult_service;

    public function __construct(FlightConsultService $service)
    {
        $this->consult_service = $service;
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
            'data' => $this->consult_service->search_flight($flight_req)
        ]);
    }

}
