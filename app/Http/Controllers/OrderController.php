<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Category;
use App\Models\Pizza;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->get();

        return view('orders.index', compact('orders'));
    }

    public function admin(Request $request)
    {
        $query = Order::query();

        // Filter by status if provided in the query parameters
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Get orders with latest first
        $orders = $query->with(['user', 'pizza'])
            ->latest()
            ->get();

        return view('orders.admin', compact('orders'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,preparing,dispatched,delivered,cancelled',
        ]);

        $order->update($validated);

        return redirect()
            ->route('admin')
            ->with('success', 'Order status updated successfully!');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pizza_id' => 'required|exists:pizzas,id',
            'quantity' => 'required|integer|min:1',
            'address' => 'required|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        $pizza = Pizza::findOrFail($validated['pizza_id']);
        $category_name = $pizza->category_name;

        $category = Category::where('cname', $category_name)->firstOrFail();
        $price = $category->price;

        $totalPrice = $price * $validated['quantity'];

        $order = Order::create([
            'user_id' => Auth::user()->id,
            'pizza_id' => $validated['pizza_id'],
            'quantity' => $validated['quantity'],
            'address' => $validated['address'],
            'notes' => $validated['notes'],
            'status' => 'pending',
            'total_price' => $totalPrice,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Order placed successfully!');
    }
}
