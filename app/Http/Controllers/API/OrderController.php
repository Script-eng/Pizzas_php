<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'pizza'])->get();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'pizza_id' => 'required|exists:pizzas,id',
            'quantity' => 'required|integer|min:1',
            'address' => 'required|string',
            'notes' => 'nullable|string',
            'total_price' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        // Set initial status to PENDING
        $orderData = $request->all();
        $orderData['status'] = OrderStatus::PENDING;

        $order = Order::create($orderData);
        return response()->json($order->load(['user', 'pizza']), Response::HTTP_CREATED);
    }

    public function show(Order $order)
    {
        return response()->json($order->load(['user', 'pizza']));
    }

    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'integer|min:1',
            'address' => 'string',
            'notes' => 'nullable|string',
            'status' => [new Enum(OrderStatus::class)],
            'total_price' => 'numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $order->update($request->all());
        return response()->json($order->load(['user', 'pizza']));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'status' => ['required', new Enum(OrderStatus::class)]
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        // Validate status transition
        if (!$this->isValidStatusTransition($order->status, OrderStatus::from($request->status))) {
            return response()->json([
                'error' => 'Invalid status transition'
            ], Response::HTTP_BAD_REQUEST);
        }

        $order->status = $request->status;
        $order->save();

        return response()->json($order->load(['user', 'pizza']));
    }

    private function isValidStatusTransition(OrderStatus $currentStatus, OrderStatus $newStatus): bool
    {
        $allowedTransitions = [
            OrderStatus::PENDING->value => [OrderStatus::PREPARING, OrderStatus::CANCELLED],
            OrderStatus::PREPARING->value => [OrderStatus::DISPATCHED, OrderStatus::CANCELLED],
            OrderStatus::DISPATCHED->value => [OrderStatus::DELIVERED],
            OrderStatus::DELIVERED->value => [],
            OrderStatus::CANCELLED->value => []
        ];

        return in_array($newStatus, $allowedTransitions[$currentStatus->value] ?? []);
    }

    public function getUserOrders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $orders = Order::where('user_id', $request->user_id)
            ->with(['pizza'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }
}
