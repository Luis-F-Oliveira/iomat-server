<?php

namespace App\Http\Controllers;

use App\Models\CollectedData;
use Illuminate\Http\Request;
use App\Exports\CollectedDataExport;
use Maatwebsite\Excel\Facades\Excel;

class CollectedDataController extends Controller
{
    public function index()
    {
        return CollectedData::with('servant')->get();
    }

    public function store(Request $request)
    {
        foreach ($request->all() as $order) {
            foreach ($order['servants'] as $servant) {
                $existingData = CollectedData::where('order', $order['order'])
                    ->where('url', $order['url'])
                    ->where('servant_id', $servant['id'])
                    ->exists();
    
                if (!$existingData) {
                    CollectedData::create([
                        'order' => $order['order'],
                        'url' => $order['url'],
                        'servant_id' => $servant['id'],
                    ]);
                }
            }
        }
    
        return response()->json(['message' => 'Dados salvos.'], 200);
    }

    public function export(Request $request)
    {
        $export = new CollectedDataExport($request->all());
        return Excel::download($export, 'collected_data.xlsx');
    }
}
