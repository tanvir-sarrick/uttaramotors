@php
    $usr = Auth::guard('web')->user();
@endphp
@extends('backend.layout.template')
@section('title', 'Import Invoice')
@section('import_invoice', 'active')
@section('invoice', 'active open')
@section('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet"
        href="{{ asset('backend/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        .custom {
            text-transform: capitalize;
        }

        .permission {
            font-size: 12px;
            line-height: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-datatable">
                    <div class="dataList" id="dataList">
                        <div class="p-4">
                            @if ($invoices->count() <= 0)
                                <!-- Info Card -->
                                <div class="card shadow-sm border-0 bg-label-warning mb-4">
                                    <div class="card-body">
                                        <h4 class="card-title text-warning text-center mb-3">Import Invoice</h4>
                                        <ul class="mb-0 ps-3">
                                            <li class="mb-1">Upload a valid Excel file in .xlsx, .xls, or .xlsm format.
                                            </li>
                                            <li class="mb-1">File size must not exceed 2MB.</li>
                                            <li>This file is required to proceed with the invoice import.</li>
                                        </ul>
                                    </div>
                                </div>
                            @endif
                            <!-- Alerts -->
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <strong>Whoops!</strong> Please fix the following issues:
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Import Form -->
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    @if ($invoices->count() <= 0)
                                        <form action="{{ route('dashboard.invoice.import') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row g-3">
                                                <!-- Select Dealer -->
                                                <div class="col-md-6">
                                                    <label for="dealerSelect" class="form-label fw-semibold">Select Dealer
                                                        <span class="text-danger">*</span></label>
                                                    <select id="dealerSelect" name="dealer_id" class="select2 form-select"
                                                        required>
                                                        <option></option>
                                                        @foreach ($dealers as $dealer)
                                                            <option value="{{ $dealer->id }}">{{ $dealer->dealer_name }} -
                                                                {{ $dealer->dealer_code }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Upload File -->
                                                <div class="col-md-6">
                                                    <label for="excelFile" class="form-label fw-semibold">
                                                        Upload Excel File <span class="text-danger">*</span>
                                                        <small class="text-muted">(Accepted: .xlsx, .xls)</small>
                                                    </label>
                                                    <input type="file" name="file" id="excelFile" class="form-control"
                                                        accept=".xls,.xlsx" required>
                                                </div>

                                                <!-- Submit Button -->
                                                <div class="col-12 text-end mt-2 px-5">
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="tf-icons ti ti-file-import me-1"></i> Import Data
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                    @if ($invoices->count() > 0)
                                        @php
                                            $totalQty = $invoices->sum('qty');
                                            $totalRate = $invoices->sum('rate'); // optional, usually not summed
                                            $totalAmount = $invoices->sum('amount');
                                        @endphp
                                        <table class="table table-bordered mt-3">
                                            <thead>
                                                <tr class="table-secondary">
                                                    <th>SN.</th>
                                                    <th>Brand</th>
                                                    <th>Part ID</th>
                                                    <th>Description</th>
                                                    <th>Qty</th>
                                                    <th>Rate</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($invoices as $user)
                                                    <tr>
                                                        <td>{{ $user->sl_no }}</td>
                                                        <td>{{ $user->brand }}</td>
                                                        <td>{{ $user->part_id }}</td>
                                                        <td>{{ $user->description }}</td>
                                                        <td>{{ $user->qty }}</td>
                                                        <td>{{ number_format($user->rate, 2) }}</td>
                                                        <td>{{ number_format($user->amount, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr class="fw-bold table-warning">
                                                    <td colspan="4" class="text-end">Total</td>
                                                    <td>{{ $totalQty }}</td>
                                                    <td>-</td>
                                                    <td>{{ number_format($totalAmount, 2) }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        @if ($usr->can('invoice.print'))
                                            <div class="d-flex justify-content-end gap-2 mt-3">
                                                <!-- Print Button -->
                                                <form action="{{ route('dashboard.invoicePrint.print') }}" method="GET"
                                                    target="_blank" style="display: inline;">
                                                    <input type="hidden" name="invoice_number"
                                                        value="{{ $invoice_number }}">
                                                    <button type="submit" class="btn btn-success waves-effect waves-light">
                                                        <i class="ti ti-printer me-1"></i> Print
                                                    </button>
                                                </form>

                                                <!-- Download Button -->
                                                <form action="{{ route('dashboard.invoicePrint.print') }}" method="GET"
                                                    target="_blank" style="display: inline;">
                                                    <input type="hidden" name="invoice_number"
                                                        value="{{ $invoice_number }}">
                                                    <input type="hidden" name="download" value="1">
                                                    <!-- Triggers download logic -->
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                        <i class="ti ti-download me-1"></i> Download
                                                    </button>
                                                </form>

                                                <!-- Clear Button -->
                                                <form id="clearInvoiceForm" action="{{ route('dashboard.invoice.clear') }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="button" class="btn btn-danger" id="confirmClearBtn">
                                                        <i class="ti ti-trash me-1"></i> Clear Data
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#dealerSelect').select2({
                placeholder: "-- Choose a Dealer --",
                allowClear: true
            });
        });
    </script>

    <script>
        document.getElementById('confirmClearBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently clear all invoice data.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, clear it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('clearInvoiceForm').submit();
                }
            });
        });
    </script>

@endsection
