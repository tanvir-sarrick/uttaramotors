<?php

namespace App\Http\Controllers\Backend;

use App\Models\Invoice;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Imports\InvoicesImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;


class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::get();
        return view('invoices.manage', compact('invoices'));
        // return view('backend.pages.invoice.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,xlsm|max:2048',
        ]);

        try {
            $now = Carbon::now();

            $datePrefix = $now->format('Ymd');
            $latestInvoice = Invoice::whereDate('created_at', $now->toDateString())->orderByDesc('id')->first();

            $sequence = $latestInvoice ? ((int) Str::afterLast($latestInvoice->invoice_number, '-') + 1) : 1;
            $invoiceNumber = 'INV-' . $datePrefix . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

            Excel::import(new InvoicesImport($invoiceNumber), $request->file('file'));

            return back()->with('success', 'Invoices imported successfully.');
        } catch (ExcelValidationException  $e) {
            // Get all failures with row and message
            $failures = $e->failures();

            // Pass errors back to the view or handle them as you like
            return back()->withErrors($failures)->withInput();
        }
    }

}
