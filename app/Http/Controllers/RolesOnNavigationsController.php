<?php

namespace App\Http\Controllers;

use App\Models\RolesOnNavigations;
use Illuminate\Http\Request;

class RolesOnNavigationsController extends Controller
{
    public function index()
    {
        return RolesOnNavigations::with('role')
            ->get();
    }

    public function store(Request $request)
    {
        return RolesOnNavigations::create($request->all());
    }

    public function show(string $id)
    {
        return RolesOnNavigations::with('role')
            ->find($id);
    }

    public function update(Request $request, string $id)
    {
        $rolesOnNavigations =  RolesOnNavigations::with('role')
            ->find($id);

        $rolesOnNavigations->update($request->all());

        return RolesOnNavigations::with('role')
            ->find($id);
    }

    public function destroy(string $id)
    {
        $rolesOnNavigations = RolesOnNavigations::with('role')
            ->find($id);
        
        $rolesOnNavigations->delete();

        return response()->json([
            'message' => 'Mapeamento deletado'
        ]);
    }
}
