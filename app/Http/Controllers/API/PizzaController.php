<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class PizzaController extends Controller
{
    public function index()
    {
        $pizzas = Pizza::with('category')->get();
        return response()->json($pizzas);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pname' => 'required|string',
            'category_name' => 'required|string|exists:categories,cname',
            'vegetarian' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $pizza = Pizza::create($request->all());
        return response()->json($pizza, Response::HTTP_CREATED);
    }

    public function show(Pizza $pizza)
    {
        return response()->json($pizza->load('category'));
    }

    public function update(Request $request, Pizza $pizza)
    {
        $validator = Validator::make($request->all(), [
            'pname' => 'string',
            'category_name' => 'string|exists:categories,cname',
            'vegetarian' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $pizza->update($request->all());
        return response()->json($pizza);
    }

    public function destroy(Pizza $pizza)
    {
        $pizza->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
