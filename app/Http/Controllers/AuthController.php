<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    function profile(Request $request) {
        return Auth::user();
    }

    function register(Request $request) {

        $request->validate([
            'name' => 'required|string|min:2|max:58',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        return response([
            'message' => 'You have registered succesfully!'
        ], 201);
    }

    function login(Request $request) {

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6'
        ]);

        $user = User::whereEmail($request->email)->first();

        if (!$user || !hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Invalid Pass'
            ], 401);
        }

        $token = $user->createToken($user->name . '_AuthToken')->plainTextToken;

        return response([
            'message' => 'You have registered succesfully!',
            'access_token' => $token
        ], 201);
    }
}
