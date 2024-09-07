<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = order::all();
        return new OrderCollection($orders);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.book_id' => 'required|exists:books,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Get the authenticated user
        $user = auth()->user();

        // Inside store method
        $total = 0;

        foreach ($request->items as $item) {
            $book = \App\Models\Book::find($item['book_id']);
            $total += $item['quantity'] * $book->price;
        }

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $total,
            'status' => 'pending',
        ]);

        // Create order items
        foreach ($request->items as $item) {
            $book = \App\Models\Book::find($item['book_id']);
            $order->items()->create([
                'book_id' => $item['book_id'],
                'quantity' => $item['quantity'],
                'price' => $book->price,
            ]);
        }

        return response()->json(['order' => new OrderResource($order)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return new orderResource($order);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Order updated successfully', 'order' => new OrderResource($order)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json('order deleted successfully');
    }
}
