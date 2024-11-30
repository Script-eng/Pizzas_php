<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\PdfService;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    private $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:categories,pizzas,orders',
            'start_date' => 'required_if:report_type,orders|date',
            'end_date' => 'required_if:report_type,orders|date|after_or_equal:start_date',
            'category' => 'nullable|exists:categories,cname'
        ]);

        $pdf = $this->pdfService->generateReport(
            $request->report_type,
            $request->start_date,
            $request->end_date,
            $request->category
        );

        return $pdf->Output('pizzeria-report.pdf', 'D');
    }
}
