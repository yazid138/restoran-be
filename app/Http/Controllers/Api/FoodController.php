<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');

        $query = Food::query();

        if ($request->has('search')) {
            $query->where('name', 'ilike', "%{$search}%");
        }

        $foods = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'data' => $foods
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'status' => 'nullable|in:available,sold_out',
            'image' => 'nullable|string',
        ]);

        $food = Food::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Food created successfully',
            'data' => $food
        ], 201);
    }

    public function show(string $id)
    {
        $food = Food::find($id);

        if (!$food) {
            return response()->json([
                'success' => false,
                'message' => 'Food not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $food
        ]);
    }

    public function update(Request $request, string $id)
    {
        $food = Food::find($id);

        if (!$food) {
            return response()->json([
                'success' => false,
                'message' => 'Food not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'status' => 'nullable|in:available,sold_out',
            'image' => 'nullable|string',
        ]);

        $food->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Food updated successfully',
            'data' => $food
        ]);
    }

    public function destroy(string $id)
    {
        $food = Food::find($id);

        if (!$food) {
            return response()->json([
                'success' => false,
                'message' => 'Food not found'
            ], 404);
        }

        $food->delete();

        return response()->json([
            'success' => true,
            'message' => 'Food deleted successfully'
        ]);
    }
}
