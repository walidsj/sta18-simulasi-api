<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ViewUserScore;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;

class AuthController extends Controller
{

    /**
     ** Encode json web token.
     *  https://chalidade.medium.com/authentication-token-for-lumen-with-php-jwt-5686f796f8d5
     * 
     *  @return void
     */
    private function jwt(User $user, $remember_me = 30)
    {
        $payload = [
            'iss' => env('APP_NAME', 'Lumen'),
            'sub' => $user->id,
            'name' => $user->name,
            'npm' => $user->npm,
            'email' => $user->email,
            'major' => $user->major,
            'email_verified_at' => $user->email_verified_at,
            'role' => $user->role,
            'user_type' => $user->user_type,
            'created_at' => Carbon::parse($user->created_at)->timestamp,
            'iat' => time(),
            'exp' => time() + 3600 * 24 * $remember_me
        ];

        return JWT::encode($payload, env('APP_KEY', 'walidganteng'));
    }


    /**
     ** Login an account.
     * 
     * @return void
     */

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (empty($user))
            return response()->json([
                'success' => false,
                'message' => 'Account is not registered.'
            ], 400);

        if (!Hash::check($request->password, $user->password))
            return response()->json([
                'success' => false,
                'message' => 'Your password is wrong.'
            ], 422);

        return response()->json([
            'success' => true,
            'message' => 'Login successfull.',
            'data' => $user,
            'token' => $this->jwt($user)
        ]);
    }


    /**
     ** Show an account.
     * 
     * @return void
     */

    public function show(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Me found.',
            'data' => $request->auth
        ]);
    }


    /**
     ** Show score of account.
     * 
     * @return void
     */

    public function score(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Me found.',
            'data' => ViewUserScore::where('user_id', $request->auth->id)->first()
        ]);
    }
}
