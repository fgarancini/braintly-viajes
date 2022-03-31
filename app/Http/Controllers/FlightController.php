<?php

namespace App\Http\Controllers;

use App\Http\Requests\FlightSearchRequest;
use App\Services\FlightConsultService;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    protected FlightConsultService $consult_service;

    public function __construct(FlightConsultService $service)
    {
        $this->consult_service = $service;
    }

    public function search(FlightSearchRequest $request)
    {
        return response()->json([
            'data' => $this->consult_service->search_flight($request->validated())
        ]);
    }
}
