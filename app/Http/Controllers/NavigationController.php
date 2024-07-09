<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Navigation;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function index()
    {
        try {
            return Navigation::with('replies')
                ->whereNull('parent_id')
                ->get();
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
                'name' => 'required|string|max:55',
                'href' => 'required|string|max:255',
                'route' => 'required|string|max:55',
                'parent_id' => 'nullable|exists:navigations,id',
            ]);

            return Navigation::create([
                'name' => $validated['name'],
                'href' => $validated['href'],
                'route' => $validated['route'],
                'parent_id' => $validated['parent_id']
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            return Navigation::with('replies')
                ->find($id);
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
                'name' => 'required|string|max:55',
                'href' => 'required|string|max:255',
                'route' => 'required|string|max:55',
                'parent_id' => 'nullable|exists:navigations,id',
            ]);

            $navigation = Navigation::findOrFail($id);

            $navigation->update([
                'name' => $validated['name'],
                'href' => $validated['href'],
                'route' => $validated['route'],
                'parent_id' => $validated['parent_id']
            ]);

            return response()->json($navigation, 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $navigation = Navigation::findOrFail($id);

            $navigation->delete();

            return response()->json([
                'message' => 'Navegação deletada'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
