<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        try {
            return User::all();
        } catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|unique:users|max:255',
                'replacement_email' => 'nullable|string|unique:users|max:255',
                'entry_code' => 'required|string|unique:users|max:6'
            ]);

            return User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'replacement_email' => $validated['replacement_email'],
                'entry_code' => $validated['entry_code']
            ]);
        } catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            return User::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|unique:users|max:255',
                'replacement_email' => 'nullable|string|unique:users|max:255',
                'entry_code' => 'required|string|max:6'
            ]);

            $user = User::findOrFail($id);

            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'replacement_email' => $validated['replacement_email'],
                'entry_code' => $validated['entry_code']
            ]);

            return $user;
        } catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            $user->delete();

            return response()->json([
                'message' => 'Usuário deletado'
            ]);
        } catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function entry_code()
    {
        try {
            $users = User::all();
            $existingCodes = $users->pluck('entry_code')->toArray();
            
            $entryCode = $this->generateUniqueEntryCode($existingCodes);
            
            return response()->json([
                'entry_code' => $entryCode
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    private function generateUniqueEntryCode($existingCodes)
    {
        do {
            $newCode = (string) rand(100000, 999999);
        } while (in_array($newCode, $existingCodes));

        return $newCode;
    }
}
