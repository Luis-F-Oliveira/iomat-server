<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RolesOnUsers;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'entry_code' => 'required|string|min:6|max:6',
            ]);

            $entry_code = $validated['entry_code'];
            $user = User::where('entry_code', $entry_code)->first();
            $roles_on_users = RolesOnUsers::with('role')
                ->where('user_id', $user->id)
                ->get();

            $abilities = $roles_on_users->pluck('role.name')->toArray();
            $token = $user->createToken('auth-token', $abilities)->plainTextToken;
            $cookie = cookie('jwt', $token, 60 * 24);

            return response()->json([
                'token' => $token
            ])->withCookie($cookie);
        } catch(Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $cookie = Cookie::forget('jwt');

            return response()->json([
                'message' => 'User logged out'
            ], 200)->withCookie($cookie);
        } catch(Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
