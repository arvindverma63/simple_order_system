<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'sizes' => 'required|array',
            'sizes.*.quantity' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Calculate total cost
        $totalCost = 0;
        foreach ($request->sizes as $size => $data) {
            if ($data['quantity'] > 0) {
                $totalCost += $data['quantity'] * 15; // $15 per shirt, no additional costs
            }
        }

        // Store order
        $order = Order::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'sizes' => $request->sizes,
            'total_cost' => $totalCost,
        ]);

        return response()->json(['message' => 'Order placed successfully!', 'order' => $order], 201);
    }

    public function index()
    {
        $orders = Order::all();
        return view('orders.index', compact('orders'));
    }
}
