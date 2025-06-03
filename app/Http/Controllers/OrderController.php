<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'sizes' => 'required|array',
            'sizes.*.quantity' => 'required|integer|min:0',
            'order_date' => 'string|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Calculate total cost with 9.73% tax
        $subtotal = 0;
        foreach ($request->sizes as $size => $data) {
            if ($data['quantity'] > 0) {
                $subtotal += $data['quantity'] * 15; // $15 per shirt
            }
        }
        $totalCost = $subtotal * 1.0973; // 9.73% tax

        // Store order
        $order = Order::create([
            'user_id' => Auth::user()->id,
            'sizes' => $request->sizes,
            'total_cost' => $totalCost,
            'phone' => Auth::user()->phone,
            'order_date' => $request->order_date
        ]);

        return response()->json(['message' => 'Order placed successfully!', 'order' => $order], 201);
    }

    public function index()
    {
        if (Auth::user()->is_admin === 0) {
            $orders = Order::where('user_id', Auth::user()->id)->get();
        }else{
            $orders = Order::all();
        }
        return view('orders.index', compact('orders'));
    }
}
