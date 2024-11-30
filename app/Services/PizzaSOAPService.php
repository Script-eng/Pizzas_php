<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Pizza;
use App\Models\Order;
use App\Models\MenuItem;

class PizzaSOAPService
{
    /**
     * Category Operations
     */
    public function getCategories()
    {
        return Category::all()->toArray();
    }

    public function getCategory($id)
    {
        return Category::findOrFail($id)->toArray();
    }

    public function createCategory($cname, $price)
    {
        return Category::create([
            'cname' => $cname,
            'price' => $price
        ])->toArray();
    }

    public function updateCategory($id, $cname, $price)
    {
        $category = Category::findOrFail($id);
        $category->update([
            'cname' => $cname,
            'price' => $price
        ]);
        return $category->toArray();
    }

    public function deleteCategory($id)
    {
        return Category::findOrFail($id)->delete();
    }

    /**
     * Pizza Operations
     */
    public function getPizzas()
    {
        return Pizza::with('category')->get()->toArray();
    }

    public function getPizza($id)
    {
        return Pizza::with('category')->findOrFail($id)->toArray();
    }

    public function createPizza($pname, $category_name, $vegetarian)
    {
        return Pizza::create([
            'pname' => $pname,
            'category_name' => $category_name,
            'vegetarian' => $vegetarian
        ])->toArray();
    }

    public function updatePizza($id, $pname, $category_name, $vegetarian)
    {
        $pizza = Pizza::findOrFail($id);
        $pizza->update([
            'pname' => $pname,
            'category_name' => $category_name,
            'vegetarian' => $vegetarian
        ]);
        return $pizza->toArray();
    }

    public function deletePizza($id)
    {
        return Pizza::findOrFail($id)->delete();
    }

    /**
     * Order Operations
     */
    public function getOrders()
    {
        return Order::with(['user', 'pizza'])->get()->toArray();
    }

    public function getOrder($id)
    {
        return Order::with(['user', 'pizza'])->findOrFail($id)->toArray();
    }

    public function createOrder($user_id, $pizza_id, $quantity, $address, $notes, $status)
    {
        $pizza = Pizza::findOrFail($pizza_id);
        $total_price = $pizza->category->price * $quantity;

        return Order::create([
            'user_id' => $user_id,
            'pizza_id' => $pizza_id,
            'quantity' => $quantity,
            'address' => $address,
            'notes' => $notes,
            'status' => $status,
            'total_price' => $total_price
        ])->toArray();
    }

    public function updateOrder($id, $status)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $status]);
        return $order->toArray();
    }

    /**
     * MenuItem Operations
     */
    public function getMenuItems()
    {
        return MenuItem::all()->toArray();
    }

    public function updateMenuItemAvailability($id, $is_available)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->update(['is_available' => $is_available]);
        return $menuItem->toArray();
    }
}
