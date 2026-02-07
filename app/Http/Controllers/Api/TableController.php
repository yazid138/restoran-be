<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Table;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::all();

        return response()->json([
            'success' => true,
            'data' => $tables
        ]);
    }

    public function show(string $id)
    {
        $table = Table::with(['orders' => function($query) {
            $query->open()->with('orderItems.food');
        }])->find($id);

        if (!$table) {
            return response()->json([
                'success' => false,
                'message' => 'Table not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $table
        ]);
    }
}
