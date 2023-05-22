<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        // Create a new user
        $user = User::create($request->validated());

        // Generate an access token for the user
        $token = $user->createToken('auth-token')->plainTextToken;

        // Return the user and token
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(LoginUserRequest $request)
    {
        $request->validated();

        // Attempt to authenticate the user
        if (Auth::attempt($request->only('email', 'password'))) {

            // Generate an access token for the authenticated user
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;

            // Return the user and token
            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        }

        // Authentication failed
        return response()->json(['message' => 'The provided credentials are incorrect.'], 401);
    }

    public function logout(Request $request)
    {
        // Revoke the current user's access token
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
