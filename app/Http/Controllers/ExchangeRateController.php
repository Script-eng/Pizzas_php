<?php

namespace App\Http\Controllers;

use App\Services\MnbService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExchangeRateController extends Controller
{
    private $mnbService;

    public function __construct(MnbService $mnbService)
    {
        $this->mnbService = $mnbService;
    }

    public function index()
    {
        return view('mnb.index');
    }

    public function getDailyRate(Request $request)
    {
        $request->validate([
            'currency_pair' => 'required|string',
            'date' => 'required|date'
        ]);

        $rate = $this->mnbService->getRateForDate(
            $request->currency_pair,
            $request->date
        );

        return response()->json(['rate' => $rate]);
    }

    public function getMonthlyRates(Request $request)
    {
        $request->validate([
            'currency_pair' => 'required|string',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:1900'
        ]);

        $rates = $this->mnbService->getMonthlyRates(
            $request->currency_pair,
            $request->month,
            $request->year
        );

        return response()->json(['rates' => $rates]);
    }
}
