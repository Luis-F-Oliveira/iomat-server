<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\RolesOnUsers;
use App\Models\User;
use Illuminate\Http\Request;

class RolesOnUsersController extends Controller
{
    public function index()
    {
        try {
            return RolesOnUsers::with('role')->get();
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'role_id' => 'required|integer|exists:roles,id',
            ]);

            $roles_on_users = RolesOnUsers::firstOrCreate([
                'user_id' => $validated['user_id'],
                'role_id' => $validated['role_id'],
            ]);

            return response()->json($roles_on_users, 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            return RolesOnUsers::with('role')->find($id);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'role_id' => 'required|integer|exists:roles,id',
            ]);

            $role_on_user = RolesOnUsers::with('role')->find($id);

            $role_on_user->update([
                'user_id' => $validated['user_id'],
                'role_id' => $validated['role_id']
            ]);

            return response()->json($role_on_user, 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $role_on_user = RolesOnUsers::with('role')->find($id);

            $role_on_user->delete();

            return response()->json([
                'message' => 'Permissão deletada'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function roles(Request $request)
    {
        try {
            $user = $request->user();
            $roles = RolesOnUsers::with('role')
                    ->where('user_id', $user->id)
                    ->get();
    
            return $roles->pluck('role.name')->toArray();
        }   catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function get_permissions(string $id)
    {
        try {
            $roles = RolesOnUsers::with('role')
                ->where('user_id', $id)
                ->get();

            return $roles;
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete_permissions(string $id)
    {
        try {
            $roles = RolesOnUsers::with('role')
                ->where('user_id', $id)
                ->get();

            foreach ($roles as $role) {
                $role->delete();
            }

            return response()->json([
                'message' => 'Permissões deletadas com sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
