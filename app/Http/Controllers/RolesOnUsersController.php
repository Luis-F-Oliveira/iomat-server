<?php

namespace App\Http\Controllers;

use App\Models\RolesOnUsers;
use App\Models\User;
use Illuminate\Http\Request;

class RolesOnUsersController extends Controller
{
    public function index()
    {
        return RolesOnUsers::with('role')->get();
    }

    public function store(Request $request)
    {
        return RolesOnUsers::create($request->all());
    }

    public function show(string $id)
    {
        return RolesOnUsers::with('role')->find($id);
    }

    public function update(Request $request, RolesOnUsers $rolesOnUsers)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function roles(Request $request)
    {
        $user = $request->user();
        $roles = RolesOnUsers::with('role')
                ->where('user_id', $user->id)
                ->get();

        return $roles->pluck('role.name')->toArray();
    }
}
