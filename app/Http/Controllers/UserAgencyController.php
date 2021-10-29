<?php

namespace App\Http\Controllers;

use App\Models\UserAgency;
use Illuminate\Http\Request;

class UserAgencyController extends Controller
{

    public function show(Request $request, $trial_id)
    {
        return response()->json([
            'success' => true,
            'message' => 'User agency succesfully added.',
            'data' => UserAgency::where('user_agencies.user_id', $request->auth->id)
                ->where('user_agencies.trial_id', $trial_id)
                ->join('trial_options', 'user_agencies.trial_option_id', '=', 'trial_options.id')
                ->join('agencies', 'user_agencies.agency_id', '=', 'agencies.id')
                ->select(['user_agencies.*', 'trial_options.title', 'agencies.name'])
                ->orderBy('name')
                ->get()
        ]);
    }

    public function store(Request $request, $trial_id, $trial_option_id)
    {
        $this->validate($request, [
            'agency_id' => 'required|numeric'
        ]);

        if (
            UserAgency::where('user_id', $request->auth->id)
            ->where('trial_id', $trial_id)
            ->where('agency_id', $request->agency_id)
            ->get()->count() > 0
        ) return response()->json([
            'success' => false,
            'message' => 'Tidak boleh memilih instansi yg sama di pilihan berbeda.',
        ], 422);

        $user_agency = UserAgency::where('user_id', $request->auth->id)
            ->where('trial_id', $trial_id)
            ->where('trial_option_id', $trial_option_id)
            ->first();

        if (empty($user_agency)) {
            $user_agency = new UserAgency();
            $user_agency->user_id = $request->auth->id;
            $user_agency->agency_id = $request->agency_id;
            $user_agency->trial_id = $trial_id;
            $user_agency->trial_option_id = $trial_option_id;
            $user_agency->save();
        } else {
            $user_agency->user_id = $request->auth->id;
            $user_agency->agency_id = $request->agency_id;
            $user_agency->trial_id = $trial_id;
            $user_agency->trial_option_id = $trial_option_id;
            $user_agency->update();
        }

        return response()->json([
            'success' => true,
            'message' => 'User agency succesfully added.',
        ]);
    }
}
