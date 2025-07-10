<?php

namespace App\Http\Controllers\Backend;

use App\Models\Dealer;
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
            $invoices = Invoice::with('dealer')
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
            // Get input from a single filter input
            $filterData = $request->input('filterData');

            // Start query builder
            $invoices = Invoice::with('dealer')
                ->select(
                    'invoice_number',
                    'dealer_id',
                    DB::raw('SUM(qty) as total_qty'),
                    DB::raw('SUM(amount) as total_amount'),
                    DB::raw('MAX(created_at) as created_at')
                );

            // ✅ Apply filter if filterData is given
            if (!empty($filterData)) {
                $invoices->where(function ($q) use ($filterData) {
                    $q->where('invoice_number', 'like', '%' . $filterData . '%')
                    ->orWhereHas('dealer', function ($q2) use ($filterData) {
                        $q2->where('dealer_code', 'like', '%' . $filterData . '%');
                    });
                });
            }

            // Grouping and pagination
            $invoices = $invoices
                ->groupBy('invoice_number', 'dealer_id')
                ->orderByDesc(DB::raw('MAX(created_at)'))
                ->paginate(2);

            // Render view and return JSON
            $data = view('backend.pages.invoice.showInvoiceList', compact('invoices'))->render();

            return response()->json([
                'data' => $data,
                'count' => $invoices->count()
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'alert_type' => 'error',
                'message'    => $th->getMessage(),
            ]);
        }
    }

    // {
    //     try {
    //         // Start query builder
    //         $invoices = Invoice::query()
    //             ->select(
    //                 'invoice_number',
    //                 'dealer_id',
    //                 DB::raw('SUM(qty) as total_qty'),
    //                 DB::raw('SUM(amount) as total_amount'),
    //                 DB::raw('MAX(created_at) as created_at')
    //             );

    //         $invoice_no = $request->input('invoice_no');
    //         // Apply filter if invoice_no is given
    //         if ($invoice_no != null) {
    //             $invoices->where('invoice_number', 'like', '%' . $invoice_no . '%');
    //         }

    //         // Grouping and pagination
    //         $invoices = $invoices
    //             ->groupBy('invoice_number', 'dealer_id')
    //             ->orderByDesc(DB::raw('MAX(created_at)'))
    //             ->paginate(2);


    //         $data = view('backend.pages.invoice.showInvoiceList', compact('invoices'))->render();

    //         return response()->json([
    //             'data' => $data,
    //             'count' => $invoices->count()
    //         ]);
    //     } catch (\Exception $th) {
    //         return response()->json([
    //             'atert_type' => 'error',
    //             'message'    => $th->getmessage(),
    //         ]);
    //     }
    // }

    // public function filterData(Request $request)
    // {
    //     try {
    //         // Start query builder
    //         $invoices = Invoice::with('dealer')
    //             ->select(
    //                 'invoice_number',
    //                 'dealer_id',
    //                 DB::raw('SUM(qty) as total_qty'),
    //                 DB::raw('SUM(amount) as total_amount'),
    //                 DB::raw('MAX(created_at) as created_at')
    //             );

    //         $invoice_no = $request->input('invoice_no');

    //         // Apply filter if invoice_no is given
    //         if ($invoice_no != null) {
    //             $invoices->where('invoice_number', 'like', '%' . $invoice_no . '%');
    //         }

    //         // Grouping and pagination
    //         $invoices = $invoices
    //             ->groupBy('invoice_number', 'dealer_id')
    //             ->orderByDesc(DB::raw('MAX(created_at)'))
    //             ->paginate(2);


    //         $data = view('backend.pages.invoice.showInvoiceList', compact('invoices'))->render();

    //         return response()->json([
    //             'data' => $data,
    //         ]);
    //     } catch (\Exception $th) {
    //         return response()->json([
    //             'atert_type' => 'error',
    //             'message'    => $th->getmessage(),
    //         ]);
    //     }
    // }

    public function filterData(Request $request)
    {
        try {
            // Store the input value from 'filterData'
            $filterData = $request->input('filterData');

            //dd($filterData);

            // Build the query
            $invoices = Invoice::with('dealer')
                ->select(
                    'invoice_number',
                    'dealer_id',
                    DB::raw('SUM(qty) as total_qty'),
                    DB::raw('SUM(amount) as total_amount'),
                    DB::raw('MAX(created_at) as created_at')
                )
                ->when($filterData, function ($query, $filterData) {
                    $query->where(function ($q) use ($filterData) {
                        $q->where('invoice_number', 'like', '%' . $filterData . '%')
                        ->orWhereHas('dealer', function ($q2) use ($filterData) {
                            $q2->where('dealer_code', 'like', '%' . $filterData . '%');
                        });
                    });
                })
                ->groupBy('invoice_number', 'dealer_id')
                ->orderByDesc(DB::raw('MAX(created_at)'))
                ->paginate(2);

            // Render the partial view
            $data = view('backend.pages.invoice.showInvoiceList', compact('invoices'))->render();

            return response()->json([
                'data' => $data,
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'alert_type' => 'error',
                'message'    => $th->getMessage(),
            ]);
        }
    }

    public function import_index()
    {
        $userId = $userId = Auth::user()->id;

        if ($userId) {
            $invoices = Invoice::where('user_id', $userId)->get();

            $invoice_number = Invoice::where('user_id', $userId)->groupBy('invoice_number')->pluck('invoice_number')->first();

            $dealers = Dealer::all();
            return view('backend.pages.invoice.import', compact('invoices', 'dealers', 'invoice_number'));
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
            $dealerId = $request->input('dealer_id');

            Excel::import(new InvoicesImport($invoiceNumber, $userId, $dealerId), $request->file('file'));

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
            return redirect()->route('dashboard.invoice.import_index');
        } else {
            // show not found page
        }
    }

    public function delete(Request $request)
    {
        $invoice_number = $request->invoice_number;

        if ($invoice_number) {
            $invoices = Invoice::where('invoice_number', $invoice_number);

            if ($invoices->exists()) {
                $invoices->delete();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Invoice deleted successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'Invoice not found.',
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid request. Invoice number is missing.',
        ], 400);
    }
}
