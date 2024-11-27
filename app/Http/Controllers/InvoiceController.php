<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class InvoiceController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function generateInvoice($orderId)
    {
        // Invoice data (replace with database values)
        $order = $this->orderService->findOrderById($orderId);
         $data = [
            'orderId' => $order->id,
            'subtotal' => $order->subtotal,
            'tax' => $order->tax,
            'total' => $order->total,
            'items' => $order->items,
            'shipping' => $order->shippingDetails,
            'payment' => $order->paymentDetails,
        ];
        
        $html = view('invoice', $data)->render();

        // Create PDF using mPDF
        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->WriteHTML($html);

        $pdfContent = $mpdf->Output("Invoice-{$orderId}.pdf", 'S'); // 'S' returns the PDF as a string
        
    return response($pdfContent, 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', "attachment; filename=Invoice-{$orderId}.pdf");

    }
}
