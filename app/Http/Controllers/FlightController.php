<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function search(Request $request) {
        // YOUR CODE HERE

        return response()->json([
            'data' => null
        ]);
    }
}
