<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function me()
    {
        $user = Auth::user();

        return [
            'email' => $user->email,
            'name' => $user->name,
            'id' => $user->id,
        ];
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.'],
            ], 401);
        }

        $token = $user->createToken('access-token')->plainTextToken;

        // response
        return response([
            'user' => $user,
            'token' => $token,
        ]);
    }
}
