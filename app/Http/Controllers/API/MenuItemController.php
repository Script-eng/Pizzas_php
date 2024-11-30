<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::all();
        return response()->json($menuItems);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:menu_items,name',
            'is_available' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $menuItem = MenuItem::create($request->all());
        return response()->json($menuItem, Response::HTTP_CREATED);
    }

    public function show(MenuItem $menuItem)
    {
        return response()->json($menuItem);
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|unique:menu_items,name,' . $menuItem->id,
            'is_available' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $menuItem->update($request->all());
        return response()->json($menuItem);
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function toggleAvailability(MenuItem $menuItem)
    {
        $menuItem->is_available = !$menuItem->is_available;
        $menuItem->save();
        return response()->json($menuItem);
    }
}
