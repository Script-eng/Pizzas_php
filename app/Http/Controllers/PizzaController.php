<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Category;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    public function index(Request $request, $category = null)
    {
        $query = Pizza::with('category');

        if ($category) {
            $query->where('category_name', $category);
        }

        $pizzas = $query->get();
        $categories = Category::orderBy('price')->get();

        return view('pizzas.index', compact('pizzas', 'categories', 'category'));
    }
}
