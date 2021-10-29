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
            'data' => Agency::where('user_type_id', 3)->orderBy('name')->get()
        ]);
    }

    public function show($agency_id)
    {
        return response()->json([
            'success' => true,
            'message' => 'Agency found.',
            'data' => Agency::findOrFail($agency_id)
        ]);
    }
}
