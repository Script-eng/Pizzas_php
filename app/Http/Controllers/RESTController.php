<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

class RESTController extends Controller
{
    public function index()
    {
        return view('restful');
    }
}
