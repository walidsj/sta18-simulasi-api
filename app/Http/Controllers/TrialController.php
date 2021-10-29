<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Trial;

class TrialController extends Controller
{

    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Trials found.',
            'data' => Trial::all()
        ]);
    }

    public function show($trial_id)
    {
        return response()->json([
            'success' => true,
            'message' => 'Trial found.',
            'data' => Trial::findOrFail($trial_id)
        ]);
    }
}
