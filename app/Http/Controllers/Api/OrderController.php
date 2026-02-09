<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);
        $status = $request->get('status');

        $query = Order::with(['table', 'waiter', 'cashier', 'orderItems.food']);

        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_id' => 'required|exists:tables,id',
            'items' => 'nullable|array|min:1',
            'items.*.food_id' => 'required_with:items|exists:foods,id',
            'items.*.quantity' => 'required_with:items|integer|min:1',
            'items.*.notes' => 'nullable|string',
        ]);

        // Check if table is available
        $table = Table::query()->available()->find($validated['table_id']);
        if (!$table) {
            return response()->json([
                'success' => false,
                'message' => 'Table not available'
            ], 400);
        }

        // Check if table already has an open order
        $existingOrder = $table->orders()->open()->first();
        if ($existingOrder) {
            return response()->json([
                'success' => false,
                'message' => 'Table already has an active order'
            ], 400);
        }

        // Create order
        $order = Order::create([
            'table_id' => $validated['table_id'],
            'waiter_id' => $request->user()->id,
            'status' => 'open',
            'total_price' => 0,
        ]);

        // Update table status to occupied
        $table->update(['status' => 'occupied']);

        // Add items if provided
        $addedItems = [];
        if ($request->has('items') && is_array($request->items)) {
            foreach ($request->items as $item) {
                $food = Food::find($item['food_id']);

                if (!$food->isAvailable()) {
                    // Rollback: delete the order and reset table status
                    $order->delete();
                    $table->update(['status' => 'available']);
                    
                    return response()->json([
                        'success' => false,
                        'message' => "Food '{$food->name}' is not available"
                    ], 400);
                }

                $orderItem = $order->addItem(
                    $food,
                    $item['quantity'],
                    $item['notes'] ?? null
                );

                $addedItems[] = $orderItem->load('food');
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => [
                'order' => $order->fresh(['table', 'waiter', 'orderItems.food']),
                'added_items' => $addedItems
            ]
        ], 201);
    }

    public function show(string $id)
    {
        $order = Order::with(['table', 'waiter', 'cashier', 'orderItems.food'])->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    /**
     * Add items to an order
     */
    public function addItems(Request $request, string $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if ($order->status !== 'open') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot add items to a closed order'
            ], 400);
        }

        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.food_id' => 'required|exists:foods,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string',
        ]);

        $addedItems = [];

        foreach ($validated['items'] as $item) {
            $food = Food::find($item['food_id']);

            if (!$food) {
                return response()->json([
                    'success' => false,
                    'message' => 'Food not found'
                ], 404);
            }

            $orderItem = $order->addItem(
                $food,
                $item['quantity'],
                $item['notes'] ?? null
            );

            $addedItems[] = $orderItem->load('food');
        }

        return response()->json([
            'success' => true,
            'message' => 'Items added to order successfully',
            'data' => [
                'order' => $order->fresh(['orderItems.food']),
                'added_items' => $addedItems
            ]
        ]);
    }

    /**
     * Close an order
     */
    public function close(Request $request, string $id)
    {
        $order = Order::with(['table', 'orderItems.food'])->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        if ($order->status === 'closed') {
            return response()->json([
                'success' => false,
                'message' => 'Order is already closed'
            ], 400);
        }

        if ($order->orderItems->count() === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot close an order with no items'
            ], 400);
        }

        // Close the order
        $order->close($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Order closed successfully',
            'data' => $order->fresh(['table', 'waiter', 'cashier', 'orderItems.food'])
        ]);
    }

    public function destroyItem(Request $request, Order $order, string $item) {
        $orderItem = $order->orderItems()->find($item);

        if (!$orderItem) {
            return response()->json([
                'success' => false,
                'message' => 'Order item not found'
            ], 404);
        }

        $orderItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order item deleted successfully',
            'data' => $order->fresh(['orderItems.food'])
        ]);
    }
}
