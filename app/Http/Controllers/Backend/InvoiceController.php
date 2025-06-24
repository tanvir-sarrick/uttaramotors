<?php

namespace App\Http\Controllers\Backend;

use App\Models\Invoice;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Imports\InvoicesImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;


class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $invoices = Invoice::query()
                ->select(
                    'invoice_number',
                    'dealer_id',
                    DB::raw('SUM(qty) as total_qty'),
                    DB::raw('SUM(amount) as total_amount'),
                    DB::raw('MAX(created_at) as created_at')
                )
                ->groupBy('invoice_number', 'dealer_id')
                ->orderByDesc(DB::raw('MAX(created_at)'))
                ->paginate(2);

            if ($request->ajax()) {
                $view = view('backend.pages.invoice.showInvoiceList', compact('invoices'))->render();
                return response()->json(['data' => $view]);
            }

            return view('backend.pages.invoice.index', compact('invoices'));
        } catch (\Exception $e) {
            return response()->json([
                'alert_type' => 'error',
                'message'    => $e->getMessage(),
            ]);
        }
    }

    public function loadMoreData(Request $request)
    {
        try {
            // Start query builder
            $invoices = Invoice::query()
                ->select(
                    'invoice_number',
                    'dealer_id',
                    DB::raw('SUM(qty) as total_qty'),
                    DB::raw('SUM(amount) as total_amount'),
                    DB::raw('MAX(created_at) as created_at')
                );

            $invoice_no = $request->input('invoice_no');
            // Apply filter if invoice_no is given
            if ($invoice_no != null) {
                $invoices->where('invoice_number', 'like', '%' . $invoice_no . '%');
            }

            // Grouping and pagination
            $invoices = $invoices
                ->groupBy('invoice_number', 'dealer_id')
                ->orderByDesc(DB::raw('MAX(created_at)'))
                ->paginate(2);


            $data = view('backend.pages.invoice.showInvoiceList', compact('invoices'))->render();

            return response()->json([
                'data' => $data,
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'atert_type' => 'error',
                'message'    => $th->getmessage(),
            ]);
        }
    }

    public function filterData(Request $request)
    {
        try {
            // Start query builder
            $invoices = Invoice::query()
                ->select(
                    'invoice_number',
                    'dealer_id',
                    DB::raw('SUM(qty) as total_qty'),
                    DB::raw('SUM(amount) as total_amount'),
                    DB::raw('MAX(created_at) as created_at')
                );

            $invoice_no = $request->input('invoice_no');

            // Apply filter if invoice_no is given
            if ($invoice_no != null) {
                $invoices->where('invoice_number', 'like', '%' . $invoice_no . '%');
            }

            // Grouping and pagination
            $invoices = $invoices
                ->groupBy('invoice_number', 'dealer_id')
                ->orderByDesc(DB::raw('MAX(created_at)'))
                ->paginate(2);


            $data = view('backend.pages.invoice.showInvoiceList', compact('invoices'))->render();

            return response()->json([
                'data' => $data,
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'atert_type' => 'error',
                'message'    => $th->getmessage(),
            ]);
        }
    }



    public function import_index()
    {
        $userId = $userId = Auth::user()->id;

        if ($userId) {
            $invoices = Invoice::where('user_id', $userId)->get();
            // dd($invoices->count());
            return view('backend.pages.invoice.import', compact('invoices'));
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

    public function clear(Request $request)
    {
        $userId = $userId = Auth::user()->id;

        if ($userId) {
            $invoices = Invoice::where('user_id', $userId)->update(['user_id' => null]);
            return redirect()->route('dashboard.invoice.import');
        } else {
            // show not found page
        }
    }
}
