<?php

namespace App\Http\Controllers;

use App\Models\Servant;
use Illuminate\Http\Request;
use App\Imports\ServantsImport;
use Maatwebsite\Excel\Facades\Excel;

class ServantController extends Controller
{
    public function index()
    {
        return Servant::all();
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:2048'
        ]);

        if ($request->hasFile('file')) {
            Servant::truncate();

            $file = $request->file('file');
            
            Excel::import(new ServantsImport, $file);

            return response()->json([
                'message' => 'File uploaded and imported successfully'
            ], 200);
        }

        return response()->json([
            'message' => 'No file uploaded'
        ], 400);
    }

    public function show(string $id)
    {
        return Servant::find($id);
    }

    public function update(Request $request, string $id)
    {
        Servant::where('id', $id)->update($request->all());
        return Servant::find($id);
    }

    public function destroy(string $id)
    {
        $servant = Servant::find($id);
        $servant->delete();

        return response()->json([
            "message" => "success"
        ], 200);
    }
}
