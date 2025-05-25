<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Imports\InvoicesImport;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    public function manage()
    {
        $invoices = Invoice::get();
        return view('invoices.manage', compact('invoices'));
    }

    public function import(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        $import = new InvoicesImport;
        Excel::import($import, $request->file('file'));


        // If there are failures, return them
        if ($import->failures()->isNotEmpty()) {
            return back()->with([
                'failures' => $import->failures(),
            ]);
        }

        return back()->with('success', 'Invoice imported successfully.');
    }
}
