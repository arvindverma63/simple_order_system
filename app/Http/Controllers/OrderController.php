<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
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

        // First, create the order without order_id
        $order = Order::create([
            'user_id' => Auth::user()->id,
            'sizes' => $request->sizes,
            'total_cost' => $totalCost,
            'phone' => Auth::user()->phone,
            'order_date' => "2025-08-01",
        ]);

        // Now update order_id using the created ID
        $order->order_id = 'ORD-' . $order->id;
        $order->save();

        return response()->json(['message' => 'Order placed successfully!', 'order' => $order], 201);
    }

    public function index(Request $request)
    {
        $query = Auth::user()->is_admin
            ? Order::query()
            : Order::where('user_id', Auth::user()->id);

        // Handle search
        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Paginate results
        $orders = $query->paginate(10)->appends(['search' => $search]);

        return view('orders.index', compact('orders'));
    }

    public function updateStatus(Request $request)
    {
        $validate = $request->validate([
            'status' => 'required|in:accept,cancel,pending',
            'order_id' => 'required|integer|exists:orders,id'
        ]);

        $order = Order::find($request->order_id);
        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found');
        }

        $order->status = $request->status;
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Status updated successfully');
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found');
        }

        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully');
    }
}
