<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::query()->with('orders', function($query) {
            $query->open()->latest()->first();
        })->orderBy('id', 'asc')->get();

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

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:available,occupied,reserved,inactive',
        ]);

        $table = Table::find($id);

        if (!$table) {
            return response()->json([
                'success' => false,
                'message' => 'Table not found'
            ], 404);
        }
        
        $table->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Table status updated successfully',
            'data' => $table
        ]);
    }
}
