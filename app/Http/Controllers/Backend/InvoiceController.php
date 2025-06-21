<?php

namespace App\Http\Controllers\Backend;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\InvoicesImport;
use Maatwebsite\Excel\Facades\Excel;

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
        // // Validate incoming request data
        // $request->validate([
        //     'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        // ]);

        // $import = new InvoicesImport;
        // Excel::import($import, $request->file('file'));


        // // If there are failures, return them
        // if ($import->failures()->isNotEmpty()) {
        //     return back()->with([
        //         'failures' => $import->failures(),
        //     ]);
        // }

        // return back()->with('success', 'Invoice imported successfully.');

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);
        // $import = new InvoicesImport;

        // Excel::import($import, $request->file('file'));

        // $skippedRows = $import->getSkippedRows();

        // if (!empty($skippedRows)) {
        //     return back()->with('skippedRows', $skippedRows);
        // }

        // return back()->with('success', 'Invoices imported successfully!');

        $import = new \App\Imports\InvoicesImport;
        Excel::import($import, $request->file('file'));

        $failures = $import->failures();

        if ($failures->isNotEmpty()) {
            return back()->with([
                'failures' => $failures,
            ]);
        }

        return back()->with('success', 'Invoices imported successfully!');
    }
}
