<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return Role::all();
    }

    public function store(Request $request)
    {
        return Role::create($request->all());
    }

    public function show(string $id)
    {
        return Role::find($id);
    }

    public function update(Request $request, Role $role)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
