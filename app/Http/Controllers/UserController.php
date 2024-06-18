<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        return User::create($request->all());
    }

    public function show(string $id)
    {
        return User::find($id);
    }

    public function update(Request $request, string $id)
    {
        User::where('id', $id)->update($request->all());
        return User::find($id);
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json([
            "message" => "success"
        ], 200);
    }

    public function entry_code()
    {
        $users = User::all();
        $existingCodes = $users->pluck('entry_code')->toArray();
        
        $entryCode = $this->generateUniqueEntryCode($existingCodes);
        
        return response()->json(['entry_code' => $entryCode]);
    }

    private function generateUniqueEntryCode($existingCodes)
    {
        do {
            $newCode = (string) rand(100000, 999999);
        } while (in_array($newCode, $existingCodes));

        return $newCode;
    }
}
