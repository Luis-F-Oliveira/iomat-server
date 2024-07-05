<?php

namespace App\Http\Controllers;

use App\Models\Navigation;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function index()
    {
        return Navigation::with('replies')
            ->whereNull('parent_id')
            ->get();
    }

    public function store(Request $request)
    {
        return Navigation::create($request->all());
    }

    public function show(string $id)
    {
        return Navigation::with('replies')
            ->find($id);
    }

    public function update(Request $request, string $id)
    {
        $navigation = Navigation::with('replies')
            ->find($id);
        
        $navigation->update($request->all());

        return Navigation::with('replies')
            ->find($id);
    }

    public function destroy(string $id)
    {
        $navigation = Navigation::with('replies')
            ->find($id);
        
        $navigation->delete();

        return response()->json([
            'message' => 'Navegação deletada'
        ]);
    }
}
