<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SoapClient;

class SOAPClientController extends Controller
{
    private $soapClient;

    public function __construct()
    {
        $this->soapClient = new SoapClient(null, [
            'location' => url('/soap'),
            'uri' => 'http://localhost:8000/soap',
            'trace' => true
        ]);
    }

    public function index()
    {
        $operations = [
            'Categories' => [
                'getCategories' => [],
                'createCategory' => ['cname', 'price'],
                'updateCategory' => ['id', 'cname', 'price'],
                'deleteCategory' => ['id'],
            ],
            'Pizzas' => [
                'getPizzas' => [],
                'createPizza' => ['pname', 'category_name', 'vegetarian'],
                'updatePizza' => ['id', 'pname', 'category_name', 'vegetarian'],
                'deletePizza' => ['id'],
            ],
            'Orders' => [
                'getOrders' => [],
                'createOrder' => ['user_id', 'pizza_id', 'quantity', 'address', 'notes', 'status'],
                'updateOrder' => ['id', 'status'],
            ],
            'Menu Items' => [
                'getMenuItems' => [],
                'updateMenuItemAvailability' => ['id', 'is_available'],
            ],
        ];

        return view('soap', compact('operations'));
    }

    public function execute(Request $request)
    {
        try {
            $method = $request->input('method');
            $params = $request->except(['_token', 'method']);

            // Filter out empty parameters
            $params = array_filter($params, fn($value) => $value !== null && $value !== '');

            $result = $this->soapClient->__soapCall($method, [$params]);

            return response()->json([
                'success' => true,
                'result' => $result,
                'request' => $this->soapClient->__getLastRequest(),
                'response' => $this->soapClient->__getLastResponse()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'request' => $this->soapClient->__getLastRequest(),
                'response' => $this->soapClient->__getLastResponse()
            ], 500);
        }
    }
}
