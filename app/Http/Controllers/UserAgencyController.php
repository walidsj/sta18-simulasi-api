<?php

namespace App\Http\Controllers;

use App\Models\UserAgency;
use Illuminate\Http\Request;

class UserAgencyController extends Controller
{

    public function show(Request $request, $trial_id, $trial_option_id)
    {
        return response()->json([
            'success' => true,
            'message' => 'User agency succesfully added.',
            'data' => UserAgency::where('user_id', $request->auth->id)
                ->where('trial_id', $trial_id)
                ->where('trial_option_id', $trial_option_id)
                ->all()
        ]);
    }

    public function store(Request $request, $trial_id, $trial_option_id)
    {
        $this->validate($request, [
            'agency_id' => 'required|numeric'
        ]);

        $user_agency = UserAgency::where('user_id', $request->auth->id)
            ->where('trial_id', $trial_id)
            // ->where('trial_option_id', $trial_option_id)
            ->first();

        if (empty($user_agency)) {
            $user_agency = new UserAgency();
            $user_agency->user_id = $request->auth->id;
            $user_agency->agency_id = $request->agency_id;
            $user_agency->trial_id = $trial_id;
            $user_agency->trial_option_id = $trial_option_id;
            $user_agency->save();
        } elseif ($user_agency->trial_option_id == $trial_option_id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak boleh memilih instansi yg sama di pilihan berbeda.',
            ], 422);
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
