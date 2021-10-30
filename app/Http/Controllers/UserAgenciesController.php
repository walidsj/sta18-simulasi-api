<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Trial;
use App\Models\UserAgency;
use App\Models\ViewUserScore;
use Illuminate\Http\Request;

class UserAgenciesController extends Controller
{

    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Trials found.',
            'data' => Trial::all()
        ]);
    }

    public function show(Request $request, $trial_id)
    {
        return response()->json([
            'success' => true,
            'message' => 'Ranking found.',
            'data' => UserAgency::where('user_agencies.trial_id', $trial_id)
                ->join('view_user_scores', 'view_user_scores.user_id', '=', 'user_agencies.user_id')
                ->where('view_user_scores.major_id', $request->auth->major_id)
                ->join('trial_options', 'user_agencies.trial_option_id', '=', 'trial_options.id')
                ->join('agencies', 'user_agencies.agency_id', '=', 'agencies.id')
                ->select(['user_agencies.*', 'trial_options.title', 'view_user_scores.npm', 'view_user_scores.skd_score', 'view_user_scores.cum_score', 'final_score', 'agencies.name'])
                ->orderBy('view_user_scores.final_score', 'desc')
                ->get()
        ]);
    }
}
