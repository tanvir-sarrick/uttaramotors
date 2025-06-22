<?php

namespace App\Http\Controllers\Backend;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Imports\InvoicesImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::get();
        return view('invoices.manage', compact('invoices'));
        // return view('backend.pages.invoice.index');
    }

    public function import1(Request $request)
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

    // public function import(Request $request)
    // {
    //     $import = new InvoicesImport();
    //     Excel::import($import, $request->file('file'));

    //     // if ($import->failures()->isNotEmpty()) {
    //     //     return back()->withErrors($import->failures());
    //     // }
    //     $failures = $import->failures();

    //     if ($failures->isNotEmpty()) {
    //         return back()->with([
    //             'failures' => $failures,
    //         ]);
    //     }
    //     $failures = $import->failures();

    //     if ($failures->isNotEmpty()) {
    //         return back()->with([
    //             'failures' => $failures,
    //         ]);
    //     }

    //     return back()->with('success', 'All rows imported successfully!');
    // }
    // public function import(Request $request)
    // {
    //     $import = new \App\Imports\InvoicesImport;

    //     Excel::import($import, $request->file('file'));

    //     if ($import->failures()->isNotEmpty()) {
    //         $errorMessages = [];

    //         foreach ($import->failures() as $failure) {
    //             $errorMessages[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
    //         }

    //         return back()->with('import_errors', $errorMessages);
    //     }

    //     return back()->with('success', 'Invoices imported successfully.');
    // }

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls,csv',
    ]);

    try {
        Excel::import(new InvoicesImport, $request->file('file'));

        return back()->with('success', 'Invoices imported successfully.');
    } catch (ValidationException $e) {
        // Get all failures with row and message
        $failures = $e->failures();

        // Pass errors back to the view or handle them as you like
        return back()->withErrors($failures)->withInput();
    }
}

}
