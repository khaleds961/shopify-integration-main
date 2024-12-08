<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $token = Auth::user()->createToken('auth_token')->plainTextToken;
            return response()->json(
                [
                    'message' => 'Logged in successfully',
                    'access_token' => $token
                ],
                200
            );
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Auth::user()->update(['access_token' => null]);
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function userAccess(Request $request){
        $user = Auth::user();
        if($user->access_token && $user->shopify_store_id){
            return response()->json([
                'success' => true
            ]);
        }
        return response()->json([
            'success' => false
        ]);
    }

}
