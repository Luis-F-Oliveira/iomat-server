<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RolesOnUsers;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $entry_code = $request->input('entry_code');
        $user = User::where('entry_code', $entry_code)->first();
        $roles_on_users = RolesOnUsers::with('role')
                            ->where('user_id', $user->id)
                            ->get();

        $abilities = $roles_on_users->pluck('role.name')->toArray();
        $token = $user->createToken('auth-token', $abilities)->plainTextToken;
        $cookie = cookie('jwt', $token, 60 * 24);

        return response()->json([
            'user' => $user,
            'token' => $token
        ])->withCookie($cookie);
    }

    public function logout(Request $request)
    {
        $cookie = Cookie::forget('jwt');

        return response()->json([
            'message' => 'success'
        ], 200)->withCookie($cookie);
    }
}
