<?php

namespace App\Http\Controllers;

use App\Models\UserType;

class UserTypeController extends Controller
{

    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Agencies found.',
            'data' => UserType::orderBy('name')->get()
        ]);
    }
}
