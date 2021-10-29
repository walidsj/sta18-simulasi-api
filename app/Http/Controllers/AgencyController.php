<?php

namespace App\Http\Controllers;

use App\Models\Agency;

class AgencyController extends Controller
{

    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Agencies found.',
            'data' => Agency::orderBy('name')->get()
        ]);
    }
}
