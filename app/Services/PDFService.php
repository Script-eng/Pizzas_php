<?php

namespace App\Services;

use TCPDF;
use App\Models\Category;
use App\Models\Pizza;
use App\Models\Order;

class PdfService
{
    private $pdf;

    public function __construct()
    {
        // Initialize TCPDF
        $this->pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

        // Set document information
        $this->pdf->SetCreator('Pizzeria System');
        $this->pdf->SetAuthor('Pizzeria Admin');
        $this->pdf->SetTitle('Pizzeria Report');

        // Set default header data
        $this->pdf->SetHeaderData('', 0, 'Pizzeria Report', date('Y-m-d H:i:s'));

        // Set header and footer fonts
        $this->pdf->setHeaderFont(['helvetica', '', 10]);
        $this->pdf->setFooterFont(['helvetica', '', 8]);

        // Set margins
        $this->pdf->SetMargins(15, 15, 15);
        $this->pdf->SetHeaderMargin(5);
        $this->pdf->SetFooterMargin(10);

        // Set auto page breaks
        $this->pdf->SetAutoPageBreak(TRUE, 25);
    }

    public function generateReport($reportType, $startDate = null, $endDate = null, $category = null)
    {
        $this->pdf->AddPage();

        switch ($reportType) {
            case 'categories':
                $this->generateCategoriesReport();
                break;
            case 'pizzas':
                $this->generatePizzasReport($category);
                break;
            case 'orders':
                $this->generateOrdersReport($startDate, $endDate);
                break;
        }

        return $this->pdf;
    }

    private function generateCategoriesReport()
    {
        $this->pdf->SetFont('helvetica', 'B', 16);
        $this->pdf->Cell(0, 10, 'Categories Report', 0, 1, 'C');
        $this->pdf->Ln(10);

        // Table header
        $this->pdf->SetFont('helvetica', 'B', 12);
        $this->pdf->Cell(90, 7, 'Category Name', 1);
        $this->pdf->Cell(90, 7, 'Base Price (€)', 1);
        $this->pdf->Ln();

        // Table content
        $this->pdf->SetFont('helvetica', '', 12);
        $categories = Category::all();

        foreach ($categories as $category) {
            $this->pdf->Cell(90, 7, $category->cname, 1);
            $this->pdf->Cell(90, 7, number_format($category->price, 2), 1);
            $this->pdf->Ln();
        }
    }

    private function generatePizzasReport($categoryName = null)
    {
        $this->pdf->SetFont('helvetica', 'B', 16);
        $this->pdf->Cell(0, 10, 'Pizzas Report', 0, 1, 'C');
        if ($categoryName) {
            $this->pdf->SetFont('helvetica', '', 12);
            $this->pdf->Cell(0, 10, "Category: $categoryName", 0, 1, 'C');
        }
        $this->pdf->Ln(5);

        // Table header
        $this->pdf->SetFont('helvetica', 'B', 12);
        $this->pdf->Cell(60, 7, 'Pizza Name', 1);
        $this->pdf->Cell(60, 7, 'Category', 1);
        $this->pdf->Cell(60, 7, 'Vegetarian', 1);
        $this->pdf->Ln();

        // Table content
        $this->pdf->SetFont('helvetica', '', 12);
        $query = Pizza::query();
        if ($categoryName) {
            $query->where('category_name', $categoryName);
        }
        $pizzas = $query->get();

        foreach ($pizzas as $pizza) {
            $this->pdf->Cell(60, 7, $pizza->pname, 1);
            $this->pdf->Cell(60, 7, $pizza->category_name, 1);
            $this->pdf->Cell(60, 7, $pizza->vegetarian ? 'Yes' : 'No', 1);
            $this->pdf->Ln();
        }
    }

    private function generateOrdersReport($startDate, $endDate)
    {
        $this->pdf->SetFont('helvetica', 'B', 16);
        $this->pdf->Cell(0, 10, 'Orders Report', 0, 1, 'C');
        $this->pdf->SetFont('helvetica', '', 12);
        $this->pdf->Cell(0, 10, "Period: $startDate to $endDate", 0, 1, 'C');
        $this->pdf->Ln(5);

        // Table header
        $this->pdf->SetFont('helvetica', 'B', 12);
        $this->pdf->Cell(25, 7, 'Order ID', 1);
        $this->pdf->Cell(50, 7, 'Pizza', 1);
        $this->pdf->Cell(30, 7, 'Quantity', 1);
        $this->pdf->Cell(40, 7, 'Status', 1);
        $this->pdf->Cell(35, 7, 'Total (€)', 1);
        $this->pdf->Ln();

        // Table content
        $this->pdf->SetFont('helvetica', '', 12);
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();

        $totalRevenue = 0;
        foreach ($orders as $order) {
            $this->pdf->Cell(25, 7, '#' . $order->id, 1);
            $this->pdf->Cell(50, 7, $order->pizza->pname, 1);
            $this->pdf->Cell(30, 7, $order->quantity, 1);
            $this->pdf->Cell(40, 7, ucfirst($order->status->value), 1);
            $this->pdf->Cell(35, 7, number_format($order->total_price, 2), 1);
            $this->pdf->Ln();

            $totalRevenue += $order->total_price;
        }

        // Summary
        $this->pdf->Ln(10);
        $this->pdf->SetFont('helvetica', 'B', 12);
        $this->pdf->Cell(0, 7, 'Summary', 0, 1);
        $this->pdf->SetFont('helvetica', '', 12);
        $this->pdf->Cell(0, 7, 'Total Orders: ' . $orders->count(), 0, 1);
        $this->pdf->Cell(0, 7, 'Total Revenue: €' . number_format($totalRevenue, 2), 0, 1);
    }
}
