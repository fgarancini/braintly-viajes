<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index(Request $request) {

        return view('flights');
    }
}
