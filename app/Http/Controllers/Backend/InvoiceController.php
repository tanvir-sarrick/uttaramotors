<?php

namespace App\Http\Controllers\Backend;

use App\Models\Invoice;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Imports\InvoicesImport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;


class InvoiceController extends Controller
{
    public function index()
    {
        $userId = $userId = Auth::user()->id;

        if($userId){
            $invoices = Invoice::where('user_id', $userId)->get();
            // dd($invoices->count());
            return view('backend.pages.invoice.index', compact('invoices'));
        } else {
            // show not found page
        }
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

            // select userid
            $userId = Auth::user()->id;

            Excel::import(new InvoicesImport($invoiceNumber, $userId), $request->file('file'));

            return back()->with('success', 'Invoices imported successfully.');
        } catch (ExcelValidationException  $e) {
            // Get all failures with row and message
            $failures = $e->failures();

            // Pass errors back to the view or handle them as you like
            return back()->withErrors($failures)->withInput();
        }
    }

    public function clear(Request $request){
        $userId = $userId = Auth::user()->id;

        if($userId){
            $invoices = Invoice::where('user_id', $userId)->update(['user_id' => null]);
            return redirect()->route('dashboard.invoice.index');
        } else {
            // show not found page
        }
    }

}
