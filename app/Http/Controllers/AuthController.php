<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // this for authenticate when user trying to login.
        if (Auth::attempt((array) $credentials, $request->boolean('remember'))) {
            $user = User::where('email', $request->email)->first();

            $token = $user->createToken($user->name, (array) $user->role, now('Asia/Kuala_Lumpur')->addHours(6));

            return response()->json([
                'status' => 'success',
                'token' => $token,
                'user' => $user,
            ]);
        }

        // if user has not match with their credentials, return this.
        return response()->json([
            'status' => 'failed',
            'message' => 'Wrong Email or Password !',
        ], 400);
    }
}
