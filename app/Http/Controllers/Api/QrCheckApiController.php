<?php

namespace App\Http\Controllers\Api;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QrCheckApiController extends Controller
{
    public function check(Request $request)
    {
        $description = $request->query('description', '');
        $invoiceNumber = $request->query('invoice_number', '');

        // Query invoices based on both description and invoice number
        $invoice = Invoice::where('description', $description)
            ->where('invoice_number', $invoiceNumber)
            ->first();

        return response()->json([
            'description' => $description,
            'invoice_number' => $invoiceNumber,
            'invoice' => $invoice,
        ]);
    }
}
