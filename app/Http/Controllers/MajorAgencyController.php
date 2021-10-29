<?php

namespace App\Http\Controllers;

use App\Models\MajorAgency;

class MajorAgencyController extends Controller
{

    public function show($major_id, $user_type_id = 1)
    {
        return response()->json([
            'success' => true,
            'message' => 'Major agent found.',
            'data' => MajorAgency::where('major_id', $major_id)
                ->select(['major_agencies.*', 'agencies.name'])
                ->join('agencies', 'major_agencies.agency_id', '=', 'agencies.id')
                ->when($user_type_id, function ($query, $user_type_id) {
                    if ($user_type_id == 1)
                        return $query->whereIn('agencies.user_type_id', [1, 2, 3]);
                    if ($user_type_id == 2)
                        return $query->where('agencies.user_type_id', [2, 3]);
                })
                ->get()
        ]);
    }
}
