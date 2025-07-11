<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Dealer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('status', 1)->count();
        $totalDealers = Dealer::where('status', 1)->count();
        $totalInvoices = Invoice::with('dealer')
            ->select('invoice_number')
            ->groupBy('invoice_number', 'dealer_id')->get()->count();

        return view('backend.pages.dashboard', compact('totalUsers', 'totalDealers', 'totalInvoices'));
    }
}
